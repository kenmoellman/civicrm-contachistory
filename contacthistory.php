<?php

require_once 'contacthistory.civix.php';
// phpcs:disable
use CRM_Contacthistory_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function contacthistory_civicrm_config(&$config): void {
  _contacthistory_civix_civicrm_config($config);
}

