<?php
use CRM_Contacthistory_ExtensionUtil as E;

class CRM_Contacthistory_Page_ContactHistory extends CRM_Core_Page {

  public function run() {
    $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
    
    // Check permission
    if (!CRM_Contact_BAO_Contact_Permission::allow($contactId, CRM_Core_Permission::VIEW)) {
      CRM_Core_Error::statusBounce(E::ts('You do not have permission to view this contact.'));
    }

    // Get history data
    $addressHistory = CRM_Contacthistory_BAO_ContacthistoryAddress::getHistory($contactId);
    $emailHistory = CRM_Contacthistory_BAO_ContacthistoryEmail::getHistory($contactId);
    $phoneHistory = CRM_Contacthistory_BAO_ContacthistoryPhone::getHistory($contactId);

    // Check manage permission
    $canManage = CRM_Core_Permission::check('administer CiviCRM') || 
                 CRM_Core_Permission::check('manage contact history');

    $this->assign('contactId', $contactId);
    $this->assign('addressHistory', $addressHistory);
    $this->assign('emailHistory', $emailHistory);
    $this->assign('phoneHistory', $phoneHistory);
    $this->assign('canManage', $canManage);

    parent::run();
  }

}
