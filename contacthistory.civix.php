<?php

// AUTO-GENERATED FILE -- Civix may overwrite any changes made to this file

/**
 * The ExtensionUtil class provides small stubs for accessing resources of this
 * extension.
 */
class CRM_Contacthistory_ExtensionUtil {
  const SHORT_NAME = 'contacthistory';
  const LONG_NAME = 'com.moellman.addresshistory';
  const CLASS_PREFIX = 'CRM_Contacthistory';

  /**
   * Translate a string using the extension's domain.
   *
   * If the extension doesn't have a specific translation
   * for the string, fallback to the default translations.
   *
   * @param string $text
   *   Canonical message text (generally en_US).
   * @param array $params
   *   Parameters for ts().
   * @return string
   *   Translated text.
   * @see ts
   */
  public static function ts($text, $params = []) {
    if (!array_key_exists('domain', $params)) {
      $params['domain'] = [self::LONG_NAME, NULL];
    }
    return ts($text, $params);
  }

  /**
   * Get the URL of a resource file (in this extension).
   *
   * @param string|NULL $file
   *   Ex: NULL.
   *   Ex: 'css/foo.css'.
   * @return string
   *   Ex: 'http://example.org/sites/default/ext/org.example.foo'.
   *   Ex: 'http://example.org/sites/default/ext/org.example.foo/css/foo.css'.
   */
  public static function url($file = NULL) {
    if ($file === NULL) {
      return rtrim(CRM_Core_Resources::singleton()->getUrl(self::LONG_NAME), '/');
    }
    return CRM_Core_Resources::singleton()->getUrl(self::LONG_NAME, $file);
  }

  /**
   * Get the path of a resource file (in this extension).
   *
   * @param string|NULL $file
   *   Ex: NULL.
   *   Ex: 'css/foo.css'.
   * @return string
   *   Ex: '/var/www/example.org/sites/default/ext/org.example.foo'.
   *   Ex: '/var/www/example.org/sites/default/ext/org.example.foo/css/foo.css'.
   */
  public static function path($file = NULL) {
    return __DIR__ . ($file === NULL ? '' : (DIRECTORY_SEPARATOR . $file));
  }

  /**
   * Get the name of a class within this extension.
   *
   * @param string $suffix
   *   Ex: 'Page_HelloWorld' or 'Page\\HelloWorld'.
   * @return string
   *   Ex: 'CRM_Foo_Page_HelloWorld'.
   */
  public static function findClass($suffix) {
    return self::CLASS_PREFIX . '_' . str_replace('\\', '_', $suffix);
  }

}

use CRM_Contacthistory_ExtensionUtil as E;

/**
 * (Delegated) Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config
 */
function _contacthistory_civix_civicrm_config(&$config = NULL) {
  static $configured = FALSE;
  if ($configured) {
    return;
  }
  $configured = TRUE;

  $template =& CRM_Core_Smarty::singleton();
  $extRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
  $extDir = $extRoot . 'templates';

  if (is_dir($extDir)) {
    $template->addTemplateDir($extDir);
  }

  $include_path = $extRoot . PATH_SEPARATOR . get_include_path();
  set_include_path($include_path);
}

/**
 * (Delegated) Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function _contacthistory_civix_civicrm_install() {
  _contacthistory_civix_civicrm_config();
  if ($upgrader = _contacthistory_civix_upgrader()) {
    $upgrader->onInstall();
  }
}

/**
 * (Delegated) Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function _contacthistory_civix_civicrm_enable() {
  _contacthistory_civix_civicrm_config();
  if ($upgrader = _contacthistory_civix_upgrader()) {
    if (is_callable([$upgrader, 'onEnable'])) {
      $upgrader->onEnable();
    }
  }
}

/**
 * (Delegated) Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function _contacthistory_civix_civicrm_disable() {
  _contacthistory_civix_civicrm_config();
  if ($upgrader = _contacthistory_civix_upgrader()) {
    if (is_callable([$upgrader, 'onDisable'])) {
      $upgrader->onDisable();
    }
  }
}

/**
 * (Delegated) Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function _contacthistory_civix_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  if ($upgrader = _contacthistory_civix_upgrader()) {
    return $upgrader->onUpgrade($op, $queue);
  }
}

/**
 * @return CRM_Contacthistory_Upgrader
 */
function _contacthistory_civix_upgrader() {
  if (!file_exists(__DIR__ . '/CRM/Contacthistory/Upgrader.php')) {
    return NULL;
  }
  else {
    return CRM_Contacthistory_Upgrader::instance();
  }
}

/**
 * (Delegated) Implements hook_civicrm_entityTypes().
 *
 * Find any *.entityType.php files, merge their content, and return.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function _contacthistory_civix_civicrm_entityTypes(&$entityTypes) {
  $entityTypes = array_merge($entityTypes, [
    'CRM_Contacthistory_DAO_ContacthistoryAddress' => [
      'name' => 'ContacthistoryAddress',
      'class' => 'CRM_Contacthistory_DAO_ContacthistoryAddress',
      'table' => 'civicrm_contacthistory_address',
    ],
    'CRM_Contacthistory_DAO_ContacthistoryEmail' => [
      'name' => 'ContacthistoryEmail',
      'class' => 'CRM_Contacthistory_DAO_ContacthistoryEmail',
      'table' => 'civicrm_contacthistory_email',
    ],
    'CRM_Contacthistory_DAO_ContacthistoryPhone' => [
      'name' => 'ContacthistoryPhone',
      'class' => 'CRM_Contacthistory_DAO_ContacthistoryPhone',
      'table' => 'civicrm_contacthistory_phone',
    ],
  ]);
}
<?php

// AUTO-GENERATED FILE -- Civix may overwrite any changes made to this file

/**
 * The ExtensionUtil class provides small stubs for accessing resources of this
 * extension.
 */
class CRM_Contacthistory_ExtensionUtil {
  const SHORT_NAME = 'contacthistory';
  const LONG_NAME = 'com.moellman.addresshistory';
  const CLASS_PREFIX = 'CRM_Contacthistory';

  /**
   * Translate a string using the extension's domain.
   *
   * If the extension doesn't have a specific translation
   * for the string, fallback to the default translations.
   *
   * @param string $text
   *   Canonical message text (generally en_US).
   * @param array $params
   *   Parameters for ts().
   * @return string
   *   Translated text.
   * @see ts
   */
  public static function ts($text, $params = []) {
    if (!array_key_exists('domain', $params)) {
      $params['domain'] = [self::LONG_NAME, NULL];
    }
    return ts($text, $params);
  }

  /**
   * Get the URL of a resource file (in this extension).
   *
   * @param string|NULL $file
   *   Ex: NULL.
   *   Ex: 'css/foo.css'.
   * @return string
   *   Ex: 'http://example.org/sites/default/ext/org.example.foo'.
   *   Ex: 'http://example.org/sites/default/ext/org.example.foo/css/foo.css'.
   */
  public static function url($file = NULL) {
    if ($file === NULL) {
      return rtrim(CRM_Core_Resources::singleton()->getUrl(self::LONG_NAME), '/');
    }
    return CRM_Core_Resources::singleton()->getUrl(self::LONG_NAME, $file);
  }

  /**
   * Get the path of a resource file (in this extension).
   *
   * @param string|NULL $file
   *   Ex: NULL.
   *   Ex: 'css/foo.css'.
   * @return string
   *   Ex: '/var/www/example.org/sites/default/ext/org.example.foo'.
   *   Ex: '/var/www/example.org/sites/default/ext/org.example.foo/css/foo.css'.
   */
  public static function path($file = NULL) {
    return __DIR__ . ($file === NULL ? '' : (DIRECTORY_SEPARATOR . $file));
  }

  /**
   * Get the name of a class within this extension.
   *
   * @param string $suffix
   *   Ex: 'Page_HelloWorld' or 'Page\\HelloWorld'.
   * @return string
   *   Ex: 'CRM_Foo_Page_HelloWorld'.
   */
  public static function findClass($suffix) {
    return self::CLASS_PREFIX . '_' . str_replace('\\', '_', $suffix);
  }

}

use CRM_Contacthistory_ExtensionUtil as E;

/**
 * (Delegated) Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config
 */
function _contacthistory_civix_civicrm_config(&$config = NULL) {
  static $configured = FALSE;
  if ($configured) {
    return;
  }
  $configured = TRUE;

  $template =& CRM_Core_Smarty::singleton();
  $extRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
  $extDir = $extRoot . 'templates';

  if (is_dir($extDir)) {
    $template->addTemplateDir($extDir);
  }

  $include_path = $extRoot . PATH_SEPARATOR . get_include_path();
  set_include_path($include_path);
}

/**
 * (Delegated) Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function _contacthistory_civix_civicrm_install() {
  _contacthistory_civix_civicrm_config();
  if ($upgrader = _contacthistory_civix_upgrader()) {
    $upgrader->onInstall();
  }
}

/**
 * (Delegated) Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function _contacthistory_civix_civicrm_enable() {
  _contacthistory_civix_civicrm_config();
  if ($upgrader = _contacthistory_civix_upgrader()) {
    if (is_callable([$upgrader, 'onEnable'])) {
      $upgrader->onEnable();
    }
  }
}

/**
 * (Delegated) Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function _contacthistory_civix_civicrm_disable() {
  _contacthistory_civix_civicrm_config();
  if ($upgrader = _contacthistory_civix_upgrader()) {
    if (is_callable([$upgrader, 'onDisable'])) {
      $upgrader->onDisable();
    }
  }
}

/**
 * (Delegated) Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function _contacthistory_civix_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  if ($upgrader = _contacthistory_civix_upgrader()) {
    return $upgrader->onUpgrade($op, $queue);
  }
}

/**
 * @return CRM_Contacthistory_Upgrader
 */
function _contacthistory_civix_upgrader() {
  if (!file_exists(__DIR__ . '/CRM/Contacthistory/Upgrader.php')) {
    return NULL;
  }
  else {
    return CRM_Contacthistory_Upgrader::instance();
  }
}

/**
 * (Delegated) Implements hook_civicrm_entityTypes().
 *
 * Find any *.entityType.php files, merge their content, and return.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function _contacthistory_civix_civicrm_entityTypes(&$entityTypes) {
  $entityTypes = array_merge($entityTypes, [
    'CRM_Contacthistory_DAO_ContacthistoryAddress' => [
      'name' => 'ContacthistoryAddress',
      'class' => 'CRM_Contacthistory_DAO_ContacthistoryAddress',
      'table' => 'civicrm_contacthistory_address',
    ],
    'CRM_Contacthistory_DAO_ContacthistoryEmail' => [
      'name' => 'ContacthistoryEmail',
      'class' => 'CRM_Contacthistory_DAO_ContacthistoryEmail',
      'table' => 'civicrm_contacthistory_email',
    ],
    'CRM_Contacthistory_DAO_ContacthistoryPhone' => [
      'name' => 'ContacthistoryPhone',
      'class' => 'CRM_Contacthistory_DAO_ContacthistoryPhone',
      'table' => 'civicrm_contacthistory_phone',
    ],
  ]);
}

