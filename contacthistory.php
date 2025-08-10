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

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function contacthistory_civicrm_install(): void {
  _contacthistory_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function contacthistory_civicrm_enable(): void {
  _contacthistory_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function contacthistory_civicrm_disable(): void {
  _contacthistory_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function contacthistory_civicrm_uninstall(): void {
  _contacthistory_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function contacthistory_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _contacthistory_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function contacthistory_civicrm_entityTypes(&$entityTypes): void {
  _contacthistory_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_tabset().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tabset
 */
function contacthistory_civicrm_tabset($tabsetName, &$tabs, $context) {
  if ($tabsetName === 'civicrm/contact/view' && !empty($context['contact_id'])) {
    $tabs[] = [
      'id' => 'contacthistory',
      'url' => CRM_Utils_System::url('civicrm/contact/view/contacthistory', [
        'cid' => $context['contact_id'],
        'snippet' => 4,
      ]),
      'title' => E::ts('Contact History'),
      'weight' => 300,
      'count' => CRM_Contacthistory_BAO_ContacthistoryAddress::getHistoryCount($context['contact_id']) +
                 CRM_Contacthistory_BAO_ContacthistoryEmail::getHistoryCount($context['contact_id']) +
                 CRM_Contacthistory_BAO_ContacthistoryPhone::getHistoryCount($context['contact_id']),
    ];
  }
}

/**
 * Implements hook_civicrm_permission().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_permission
 */
function contacthistory_civicrm_permission(&$permissions) {
  $permissions['manage contact history'] = [
    E::ts('CiviCRM: Manage Contact History'),
    E::ts('Edit and delete contact history records'),
  ];
}

