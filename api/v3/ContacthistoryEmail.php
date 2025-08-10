<?php
use CRM_Contacthistory_ExtensionUtil as E;

/**
 * ContacthistoryEmail.create API specification (optional).
 */
function _civicrm_api3_contacthistory_email_create_spec(&$spec) {
  $spec['contact_id']['api.required'] = 1;
}

/**
 * ContacthistoryEmail.create API.
 */
function civicrm_api3_contacthistory_email_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'ContacthistoryEmail');
}

/**
 * ContacthistoryEmail.delete API.
 */
function civicrm_api3_contacthistory_email_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * ContacthistoryEmail.get API.
 */
function civicrm_api3_contacthistory_email_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'ContacthistoryEmail');
}
