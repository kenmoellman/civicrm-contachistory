<?php
use CRM_Contacthistory_ExtensionUtil as E;

class CRM_Contacthistory_Form_Edit extends CRM_Core_Form {

  protected $_id;
  protected $_type;
  protected $_contactId;

  public function preProcess() {
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this);
    $this->_type = CRM_Utils_Request::retrieve('type', 'String', $this, TRUE);
    $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);

    // Check permission
    if (!CRM_Core_Permission::check('administer CiviCRM') && 
        !CRM_Core_Permission::check('manage contact history')) {
      CRM_Core_Error::statusBounce(E::ts('You do not have permission to edit contact history.'));
    }

    $this->setPageTitle(E::ts('Edit Contact History'));
  }

  public function buildQuickForm() {
    // Build form based on type
    switch ($this->_type) {
      case 'address':
        $this->buildAddressForm();
        break;
      case 'email':
        $this->buildEmailForm();
        break;
      case 'phone':
        $this->buildPhoneForm();
        break;
    }

    $this->addButtons([
      [
        'type' => 'upload',
        'name' => E::ts('Save'),
        'isDefault' => TRUE,
      ],
      [
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
      ],
    ]);

    parent::buildQuickForm();
  }

  protected function buildAddressForm() {
    // Add address form elements
    $this->add('text', 'street_address', E::ts('Street Address'));
    $this->add('text', 'city', E::ts('City'));
    $this->add('text', 'postal_code', E::ts('Postal Code'));
    
    // Add location type
    $locationTypes = CRM_Core_BAO_Address::buildOptions('location_type_id');
    $this->add('select', 'location_type_id', E::ts('Location Type'), $locationTypes);
    
    // Add checkboxes
    $this->add('checkbox', 'is_primary', E::ts('Primary?'));
    $this->add('checkbox', 'is_billing', E::ts('Billing?'));
  }

  protected function buildEmailForm() {
    $this->add('text', 'email', E::ts('Email'), [], TRUE);
    
    $locationTypes = CRM_Core_BAO_Email::buildOptions('location_type_id');
    $this->add('select', 'location_type_id', E::ts('Location Type'), $locationTypes);
    
    $this->add('checkbox', 'is_primary', E::ts('Primary?'));
    $this->add('checkbox', 'is_billing', E::ts('Billing?'));
  }

  protected function buildPhoneForm() {
    $this->add('text', 'phone', E::ts('Phone'), [], TRUE);
    $this->add('text', 'phone_ext', E::ts('Extension'));
    
    $locationTypes = CRM_Core_BAO_Phone::buildOptions('location_type_id');
    $this->add('select', 'location_type_id', E::ts('Location Type'), $locationTypes);
    
    $phoneTypes = CRM_Core_BAO_Phone::buildOptions('phone_type_id');
    $this->add('select', 'phone_type_id', E::ts('Phone Type'), $phoneTypes);
    
    $this->add('checkbox', 'is_primary', E::ts('Primary?'));
    $this->add('checkbox', 'is_billing', E::ts('Billing?'));
  }

  public function setDefaultValues() {
    $defaults = [];
    
    if ($this->_id) {
      $className = 'CRM_Contacthistory_BAO_Contacthistory' . ucfirst($this->_type);
      if (class_exists($className)) {
        $bao = new $className();
        $bao->id = $this->_id;
        if ($bao->find(TRUE)) {
          $defaults = $bao->toArray();
        }
      }
    }
    
    return $defaults;
  }

  public function postProcess() {
    $values = $this->exportValues();
    $values['contact_id'] = $this->_contactId;
    
    if ($this->_id) {
      $values['id'] = $this->_id;
    }

    $className = 'CRM_Contacthistory_BAO_Contacthistory' . ucfirst($this->_type);
    if (class_exists($className)) {
      $className::create($values);
    }

    CRM_Core_Session::setStatus(E::ts('Contact history has been saved.'), E::ts('Saved'), 'success');
    
    $url = CRM_Utils_System::url('civicrm/contact/view/contacthistory', [
      'cid' => $this->_contactId,
      'reset' => 1,
    ]);
    CRM_Utils_System::redirect($url);
  }

}
