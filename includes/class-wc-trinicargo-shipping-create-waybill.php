<?php
if(!class_exists('Wc_Trinicargo_Shipping_Create_Waybill')) {
  /**
   *
   */


  class Wc_Trinicargo_Shipping_Create_Waybill
  {

    protected $waybills = [];
    private $order_id = 0;


    function __construct()
    {

    }

    public function init($order, $opts)
    {
      $this->__waybills = [];
      $this->order_id = $order->get_id();
      $items = $order->get_items();
      $delivery_address = $this->set_address_info([
        $order->get_formatted_shipping_full_name(),
        $order->get_shipping_address_1(),
        $order->get_shipping_address_2(),
        $order->get_shipping_city(),
        'N/A',
        'N/A',
        '0000000000',
        'TTO'
      ]);

      $pickup_address = $this->set_address_info([
        $opts['waybill_pickupcosignee'], // find store name or owner name
        $opts['waybill_pickupaddress'],
        $opts['waybill_pickupaddress1'],
        $opts['waybill_pickupcity'],
        'N/A',
        'N/A',
        '0000000000',
        'TTO'
      ]);

      $pickup_days = new DateInterval("P${opts['waybill_pickupdays']}D");
      $paid_date = is_null($order->get_date_paid())? $order->get_date_created( 'edit' ) : $order->get_date_paid();
      $paid_date->add($pickup_days);
      $waybill_opts = array_intersect_key(
                  $opts,
                  array_flip(['waybill_username',
                            'waybill_password','waybill_customer_id'] )
        );

      foreach ($items as $key => $item) {
        if($item->is_type( 'line_item' )){
          $waybill = $this->prepare(
            $item->get_product(),
            $item->get_quantity(),
            $paid_date->format('Y-m-d'),
            $delivery_address,
            $pickup_address,
            $waybill_opts
          );

          $waybill->GUIANumber = $this->create($waybill);
          if(!empty($waybill->GUIANumber))
          {
            array_push($this->__waybills, $waybill);
            $this->update_order($waybill);
          }
        }
      }
    }



    public function waybill_error($error, $type = 'waybill_error')
    {
        WC_Admin_Notices::add_custom_notice($type ,sprintf('<p>%s</p>', $error));
    }

    public function create($waybill)
    {
        $result = $this->__make_soap_request($waybill);
        if(!$result) {
          $this->waybill_error(sprintf('Error Creating WayBill for Order ID# %s %s',$this->order_id, $waybill->Comments));
          return false;
        } elseif($result->CreateWayBillResult->Result == false)
        {
          $this->waybill_error(sprintf('CreateWayBillResult: %s for Order #ID %s %s'
            ,$result->CreateWayBillResult->Message, $this->order_id, $waybill->Comments));

          return false;
        }

        return $result->CreateWayBillResult->GUIANumber;
    }

    public function update_order($waybill)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $waybill->PickupRequestDate);
        $order = wc_get_order( $this->order_id );
        try {
          $order->add_order_note(sprintf(
              "Waybill #%s has been created for Order #%s Product %s to be picked up on %s "
              ,$waybill->GUIANumber
              ,$this->order_id
              ,$waybill->Comments
              ,$date->format('l jS F Y')
          ));
        } catch(\Exception $e)
        {
          WC_Admin_Notices::add_custom_notice('order_note' ,sprintf('<p>Error: %s for Order ID# %s %s</p>', $e->getMessage(), $this->order_id, $waybill->Comments  ));
        }
    }

    public function add_order_notes_to_email( $order, $sent_to_admin = true  ) {

      if($sent_to_admin)
      {
          print('<h2 style="color: #96588a; display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">Waybill Information</h2>');
      }else {
        print('<h2 style="color: #96588a; display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">Delivery Tracking Information</h2>');
      }

      foreach($this->waybills() as $waybill)
      {
          printf("<table><tr><th>Tracking Number:</th><td>%s</td></tr>", $waybill->GUIANumber);
          printf("<tr><th>Product Information:</th><td>%s</td></tr></table>", $waybill->Comments);
      }
    }

    public function waybills()
    {
        return $this->__waybills;
    }

    private function __make_soap_request(WayBill $bill)
    {
      $results = null;

      try {
        $client = new SoapClient( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wsdl/WayBill.wsdl', ['trace' => true, 'exceptions' => true ]  );
        $results = $client->__soapCall('CreateWayBill', ['parameters' =>  ['objWayBillDetails' => $bill->__toArray() ]]);
      } catch (SoapFault $e) {
        $this->waybill_error(sprintf('CreateWayBillResult: %s', $e->getMessage()), 'soap_error');
      }

      return $results;
    }

    protected function prepare($item, $qty, $pickup_date, $delivery_address, $pickup_address, $opts)
    {
        $waybill = new Waybill;
        $waybill->ElectronicWeight = $waybill->ActualWeight = $waybill->ClientWeight = $item->get_weight();
        $waybill->Length = $item->get_length();
        $waybill->Width = $item->get_width();
        $waybill->Height = $item->get_height();
        $waybill->Pieces = $qty;
        $waybill->DeclaredValue = $item->get_price();
        $waybill->ContentSdtl = $item->get_name();
        $waybill->Comments = $item->get_formatted_name();
        $waybill->DeliveryAddress = $delivery_address;
        $waybill->PickUpAddress = $pickup_address;
        $waybill->Password = $opts['waybill_password'];
        $waybill->Username = $opts['waybill_username'];
        $waybill->CustomerID = $opts['waybill_customer_id'];
        $waybill->PickupRequestDate = $pickup_date;

        return $waybill;
    }

    protected function set_address_info($info)
    {
        $address_info = new AddressInfo();
        $address_keys = array_keys($address_info->__toArray());
        $params = array_combine($address_keys, $info);
        $address_info->set_parameters($params);

        return $address_info;
    }
  }
}
 ?>
