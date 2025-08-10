<?php
use CRM_Contacthistory_ExtensionUtil as E;

/**
 * ContacthistoryPhone.create API specification (optional).
 */
function _civicrm_api3_contacthistory_phone_create_spec(&$spec) {
  $spec['contact_id']['api.required'] = 1;
}

/**
 * ContacthistoryPhone.create API.
 */
function civicrm_api3_contacthistory_phone_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'ContacthistoryPhone');
}

/**
 * ContacthistoryPhone.delete API.
 */
function civicrm_api3_contacthistory_phone_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * ContacthistoryPhone.get API.
 */
function civicrm_api3_contacthistory_phone_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'ContacthistoryPhone');
}
