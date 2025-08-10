<?php
use CRM_Contacthistory_ExtensionUtil as E;

class CRM_Contacthistory_BAO_ContacthistoryAddress extends CRM_Contacthistory_DAO_ContacthistoryAddress {

  /**
   * Create a new ContacthistoryAddress based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Contacthistory_DAO_ContacthistoryAddress|NULL
   */
  public static function create($params) {
    $className = 'CRM_Contacthistory_DAO_ContacthistoryAddress';
    $entityName = 'ContacthistoryAddress';
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
    $sql = "SELECT COUNT(*) FROM civicrm_contacthistory_address WHERE contact_id = %1";
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
      SELECT h.*, lt.display_name as location_type, sp.name as state_province, c.name as country
      FROM civicrm_contacthistory_address h
      LEFT JOIN civicrm_location_type lt ON h.location_type_id = lt.id
      LEFT JOIN civicrm_state_province sp ON h.state_province_id = sp.id
      LEFT JOIN civicrm_country c ON h.country_id = c.id
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

