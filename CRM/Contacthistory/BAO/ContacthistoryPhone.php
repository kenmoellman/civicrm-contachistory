<?php
use CRM_Contacthistory_ExtensionUtil as E;

class CRM_Contacthistory_BAO_ContacthistoryPhone extends CRM_Contacthistory_DAO_ContacthistoryPhone {

  /**
   * Create a new ContacthistoryPhone based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Contacthistory_DAO_ContacthistoryPhone|NULL
   */
  public static function create($params) {
    $className = 'CRM_Contacthistory_DAO_ContacthistoryPhone';
    $entityName = 'ContacthistoryPhone';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }

  /**
   * Get history count for a contact
   *
   * @param int $contactId
   * @return int
   */
  public static function getHistoryCount($contactId) {
    $sql = "SELECT COUNT(*) FROM civicrm_contacthistory_phone WHERE contact_id = %1";
    return CRM_Core_DAO::singleValueQuery($sql, [1 => [$contactId, 'Integer']]);
  }

  /**
   * Get history for a contact
   *
   * @param int $contactId
   * @return array
   */
  public static function getHistory($contactId) {
    $sql = "
      SELECT h.*, lt.display_name as location_type, pt.display_name as phone_type
      FROM civicrm_contacthistory_phone h
      LEFT JOIN civicrm_location_type lt ON h.location_type_id = lt.id
      LEFT JOIN civicrm_option_value pt ON h.phone_type_id = pt.value AND pt.option_group_id = (
        SELECT id FROM civicrm_option_group WHERE name = 'phone_type'
      )
      WHERE h.contact_id = %1
      ORDER BY h.start_date DESC, h.id DESC
    ";
    
    $dao = CRM_Core_DAO::executeQuery($sql, [1 => [$contactId, 'Integer']]);
    $results = [];
    while ($dao->fetch()) {
      $results[] = $dao->toArray();
    }
    return $results;
  }

}
