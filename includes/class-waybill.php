<?php
/**
 *
 */
 abstract class PropertyBag {
   public $size = 0;

   public function set_parameters(array $params ) {
     foreach ($params as $key => $value) {
       if(array_key_exists($key, $this->propertyBag) && !empty($value))
        $this->propertyBag[$key] = $value;
     }
   }

   public function __set($name, $value) {
      $this->propertyBag[$name] = $value;
      $this->size = count($this->propertyBag);
   }
   public function __get($name) {
      if (array_key_exists($name, $this->propertyBag)) {
         return $this->propertyBag[$name];
      } else {
         return null;
      }
   }
   public function __isset($name) {
      return isset($this->propertyBag[$name]);
   }
   public function __unset($name) {
      unset($this->propertyBag[$name]);
      $this->size = count($this->propertyBag);
   }

   public function __toArray()
   {
     return $this->propertyBag;
   }

}


class WayBill extends PropertyBag
{
  protected $propertyBag;

  public function __construct()
  {
    $this->propertyBag = [
      'ActualWeight' => 0,
      'Branch' => 'TRI',
      'ClientWeight' => 0,
      'Comments' => 'N/A',
      'Company' => 30,
      'ContentSdtl' => 'N/A',
      'CustomerId' => 'WS_CUSTOMER',
      'DeclaredValue' => 0.00,
      'DeliveryAddress' => 'N/A',
      'ElectronicWeight'=>0,
      'GUIANumber'=>'',
      'Height'=>0,
      'Idtrx'=>75,
      'Length'=>10,
      'Password'=>'null',
      'PickUpConsignee'=> 'WS_CUSTOMER',
      'PickUpAddress' => 'N/A',
      'PickupRequestDate'=> 'N/A',
      'Pieces'=>1,
      'Service'=>'WEB_REG',
      'UnitDimensions'=>'cm',
      'Username'=> 'null',
      'Warehouseid' => 'MAIN_OFFICE',
      'Warehouseidloc' => 'POS',
      'WeightUnit' => 'lbs',
      'Width'=>0,
    ];
  }

  public function set_address_info(array $address, $key = 'DeliveryAddress')
  {
     $add = new AddressInfo();
     $add->set_parameters($address);
     $this->__set($key, $add);
  }

  public function __toArray()
  {
    if($this->DeliveryAddress instanceof AddressInfo)
      $this->__set('DeliveryAddress', $this->DeliveryAddress->__toArray());

    if($this->PickUpAddress instanceof AddressInfo)
      $this->__set('PickUpAddress', $this->PickUpAddress->__toArray());

    return $this->propertyBag;
  }
}

class AddressInfo extends PropertyBag {

  protected $propertyBag;

  public function __construct()
  {
    $this->propertyBag = [
      'Name'=>'N/A',
      'AddressLine1' => 'N/A',
      'AddressLine2' => 'N/A',
      'City'=>'N/A',
      'State' => 'N/A',
      'ZipCode' => 'N/A',
      'Phone1'=>'0000000000',
      'CountryCode' => 'TTO'
    ];
  }
}

/**
 *
 */
class WayBillResponse extends PropertyBag
{
  protected $propertyBag;

  function __construct()
  {
    $this->propertyBag = [
      'GUIANumber'=>'N/A',
      'Idk' => 'N/A',
      'Message' => 'N/A',
      'Result' => false
    ];

    add_action( 'admin_notices', array( $this, 'render' ) );
  }

  public function render()
  {
    printf(
    '<div class="notice notice-error is-dismissible"><p>%s</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>',
      __($this->Message)
    );
  }
}
