<?php
use CRM_Contacthistory_ExtensionUtil as E;

/**
 * ContacthistoryAddress.create API specification (optional).
 */
function _civicrm_api3_contacthistory_address_create_spec(&$spec) {
  $spec['contact_id']['api.required'] = 1;
}

/**
 * ContacthistoryAddress.create API.
 */
function civicrm_api3_contacthistory_address_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'ContacthistoryAddress');
}

/**
 * ContacthistoryAddress.delete API.
 */
function civicrm_api3_contacthistory_address_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * ContacthistoryAddress.get API.
 */
function civicrm_api3_contacthistory_address_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'ContacthistoryAddress');
}

