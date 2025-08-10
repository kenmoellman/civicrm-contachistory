<?php
use CRM_Contacthistory_ExtensionUtil as E;

class CRM_Contacthistory_Form_Delete extends CRM_Core_Form {

  protected $_id;
  protected $_type;
  protected $_contactId;

  public function preProcess() {
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
    $this->_type = CRM_Utils_Request::retrieve('type', 'String', $this, TRUE);
    $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);

    // Check permission
    if (!CRM_Core_Permission::check('administer CiviCRM') && 
        !CRM_Core_Permission::check('manage contact history')) {
      CRM_Core_Error::statusBounce(E::ts('You do not have permission to delete contact history.'));
    }

    $this->setPageTitle(E::ts('Delete Contact History Record'));
  }

  public function buildQuickForm() {
    $this->addButtons([
      [
        'type' => 'upload',
        'name' => E::ts('Delete'),
        'isDefault' => TRUE,
      ],
      [
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
      ],
    ]);

    $this->assign('type', $this->_type);
    $this->assign('contactId', $this->_contactId);

    parent::buildQuickForm();
  }

  public function postProcess() {
    $className = 'CRM_Contacthistory_BAO_Contacthistory' . ucfirst($this->_type);
    if (class_exists($className)) {
      $bao = new $className();
      $bao->id = $this->_id;
      if ($bao->find(TRUE)) {
        $bao->delete();
      }
    }

    CRM_Core_Session::setStatus(E::ts('Contact history record has been deleted.'), E::ts('Deleted'), 'success');
    
    $url = CRM_Utils_System::url('civicrm/contact/view/contacthistory', [
      'cid' => $this->_contactId,
      'reset' => 1,
    ]);
    CRM_Utils_System::redirect($url);
  }

}

