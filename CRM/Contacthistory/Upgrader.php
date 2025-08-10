<?php
use CRM_Contacthistory_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Contacthistory_Upgrader extends CRM_Extension_Upgrader_Base {

  /**
   * Install the extension.
   */
  public function install(): void {
    $this->executeSqlFile('sql/install.sql');
  }

  /**
   * Uninstall the extension.
   */
  public function uninstall(): void {
    $this->executeSqlFile('sql/uninstall.sql');
  }

  /**
   * Enable the extension.
   */
  public function enable(): void {
    $this->executeSqlFile('sql/enable.sql');
  }

  /**
   * Disable the extension.
   */
  public function disable(): void {
    $this->executeSqlFile('sql/disable.sql');
  }

}
