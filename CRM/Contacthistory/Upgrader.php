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
    $this->dropTriggers();
    $this->executeSqlFile('sql/uninstall.sql');
  }

  /**
   * Enable the extension.
   */
  public function enable(): void {
    $this->executeSqlFile('sql/enable.sql');
    $this->createTriggers();
  }

  /**
   * Disable the extension.
   */
  public function disable(): void {
    $this->dropTriggers();
    $this->executeSqlFile('sql/disable.sql');
  }

  /**
   * Create database triggers for history tracking.
   */
  private function createTriggers(): void {
    // Drop existing triggers first
    $this->dropTriggers();

    // Address triggers
    $this->createAddressTriggers();
    
    // Email triggers
    $this->createEmailTriggers();
    
    // Phone triggers
    $this->createPhoneTriggers();
  }

  /**
   * Drop database triggers.
   */
  private function dropTriggers(): void {
    $triggers = [
      'tr_address_insert_history',
      'tr_address_update_history', 
      'tr_address_delete_history',
      'tr_email_insert_history',
      'tr_email_update_history',
      'tr_email_delete_history',
      'tr_phone_insert_history',
      'tr_phone_update_history',
      'tr_phone_delete_history'
    ];

    foreach ($triggers as $trigger) {
      CRM_Core_DAO::executeQuery("DROP TRIGGER IF EXISTS {$trigger}");
    }
  }

  /**
   * Create address history triggers.
   */
  private function createAddressTriggers(): void {
    // Insert trigger
    $sql = "
      CREATE TRIGGER tr_address_insert_history
      AFTER INSERT ON civicrm_address
      FOR EACH ROW
      BEGIN
        INSERT INTO civicrm_contacthistory_address (
          contact_id, location_type_id, is_primary, is_billing, street_address,
          street_number, street_number_suffix, street_number_predirectional,
          street_name, street_type, street_number_postdirectional, street_unit,
          supplemental_address_1, supplemental_address_2, supplemental_address_3,
          city, county_id, state_province_id, postal_code_suffix, postal_code,
          usps_adr_dp, country_id, geo_code_1, geo_code_2, manual_geo_code,
          timezone, name, master_id
        ) VALUES (
          NEW.contact_id, NEW.location_type_id, NEW.is_primary, NEW.is_billing, NEW.street_address,
          NEW.street_number, NEW.street_number_suffix, NEW.street_number_predirectional,
          NEW.street_name, NEW.street_type, NEW.street_number_postdirectional, NEW.street_unit,
          NEW.supplemental_address_1, NEW.supplemental_address_2, NEW.supplemental_address_3,
          NEW.city, NEW.county_id, NEW.state_province_id, NEW.postal_code_suffix, NEW.postal_code,
          NEW.usps_adr_dp, NEW.country_id, NEW.geo_code_1, NEW.geo_code_2, NEW.manual_geo_code,
          NEW.timezone, NEW.name, NEW.master_id
        );
      END
    ";
    CRM_Core_DAO::executeQuery($sql);

    // Update trigger
    $sql = "
      CREATE TRIGGER tr_address_update_history
      AFTER UPDATE ON civicrm_address
      FOR EACH ROW
      BEGIN
        UPDATE civicrm_contacthistory_address 
        SET end_date = NOW() 
        WHERE contact_id = OLD.contact_id 
          AND location_type_id = OLD.location_type_id 
          AND end_date IS NULL;
          
        INSERT INTO civicrm_contacthistory_address (
          contact_id, location_type_id, is_primary, is_billing, street_address,
          street_number, street_number_suffix, street_number_predirectional,
          street_name, street_type, street_number_postdirectional, street_unit,
          supplemental_address_1, supplemental_address_2, supplemental_address_3,
          city, county_id, state_province_id, postal_code_suffix, postal_code,
          usps_adr_dp, country_id, geo_code_1, geo_code_2, manual_geo_code,
          timezone, name, master_id
        ) VALUES (
          NEW.contact_id, NEW.location_type_id, NEW.is_primary, NEW.is_billing, NEW.street_address,
          NEW.street_number, NEW.street_number_suffix, NEW.street_number_predirectional,
          NEW.street_name, NEW.street_type, NEW.street_number_postdirectional, NEW.street_unit,
          NEW.supplemental_address_1, NEW.supplemental_address_2, NEW.supplemental_address_3,
          NEW.city, NEW.county_id, NEW.state_province_id, NEW.postal_code_suffix, NEW.postal_code,
          NEW.usps_adr_dp, NEW.country_id, NEW.geo_code_1, NEW.geo_code_2, NEW.manual_geo_code,
          NEW.timezone, NEW.name, NEW.master_id
        );
      END
    ";
    CRM_Core_DAO::executeQuery($sql);

    // Delete trigger
    $sql = "
      CREATE TRIGGER tr_address_delete_history
      AFTER DELETE ON civicrm_address
      FOR EACH ROW
      BEGIN
        UPDATE civicrm_contacthistory_address 
        SET end_date = NOW() 
        WHERE contact_id = OLD.contact_id 
          AND location_type_id = OLD.location_type_id 
          AND end_date IS NULL;
      END
    ";
    CRM_Core_DAO::executeQuery($sql);
  }

  /**
   * Create email history triggers.
   */
  private function createEmailTriggers(): void {
    // Insert trigger
    $sql = "
      CREATE TRIGGER tr_email_insert_history
      AFTER INSERT ON civicrm_email
      FOR EACH ROW
      BEGIN
        INSERT INTO civicrm_contacthistory_email (
          contact_id, location_type_id, email, is_primary, is_billing,
          on_hold, is_bulkmail, hold_date, reset_date,
          signature_text, signature_html
        ) VALUES (
          NEW.contact_id, NEW.location_type_id, NEW.email, NEW.is_primary, NEW.is_billing,
          NEW.on_hold, NEW.is_bulkmail, NEW.hold_date, NEW.reset_date,
          NEW.signature_text, NEW.signature_html
        );
      END
    ";
    CRM_Core_DAO::executeQuery($sql);

    // Update trigger
    $sql = "
      CREATE TRIGGER tr_email_update_history
      AFTER UPDATE ON civicrm_email
      FOR EACH ROW
      BEGIN
        UPDATE civicrm_contacthistory_email 
        SET end_date = NOW() 
        WHERE contact_id = OLD.contact_id 
          AND location_type_id = OLD.location_type_id 
          AND end_date IS NULL;
          
        INSERT INTO civicrm_contacthistory_email (
          contact_id, location_type_id, email, is_primary, is_billing,
          on_hold, is_bulkmail, hold_date, reset_date,
          signature_text, signature_html
        ) VALUES (
          NEW.contact_id, NEW.location_type_id, NEW.email, NEW.is_primary, NEW.is_billing,
          NEW.on_hold, NEW.is_bulkmail, NEW.hold_date, NEW.reset_date,
          NEW.signature_text, NEW.signature_html
        );
      END
    ";
    CRM_Core_DAO::executeQuery($sql);

    // Delete trigger
    $sql = "
      CREATE TRIGGER tr_email_delete_history
      AFTER DELETE ON civicrm_email
      FOR EACH ROW
      BEGIN
        UPDATE civicrm_contacthistory_email 
        SET end_date = NOW() 
        WHERE contact_id = OLD.contact_id 
          AND location_type_id = OLD.location_type_id 
          AND end_date IS NULL;
      END
    ";
    CRM_Core_DAO::executeQuery($sql);
  }

  /**
   * Create phone history triggers.
   */
  private function createPhoneTriggers(): void {
    // Insert trigger
    $sql = "
      CREATE TRIGGER tr_phone_insert_history
      AFTER INSERT ON civicrm_phone
      FOR EACH ROW
      BEGIN
        INSERT INTO civicrm_contacthistory_phone (
          contact_id, location_type_id, is_primary, is_billing,
          mobile_provider_id, phone, phone_ext, phone_numeric, phone_type_id
        ) VALUES (
          NEW.contact_id, NEW.location_type_id, NEW.is_primary, NEW.is_billing,
          NEW.mobile_provider_id, NEW.phone, NEW.phone_ext, NEW.phone_numeric, NEW.phone_type_id
        );
      END
    ";
    CRM_Core_DAO::executeQuery($sql);

    // Update trigger
    $sql = "
      CREATE TRIGGER tr_phone_update_history
      AFTER UPDATE ON civicrm_phone
      FOR EACH ROW
      BEGIN
        UPDATE civicrm_contacthistory_phone 
        SET end_date = NOW() 
        WHERE contact_id = OLD.contact_id 
          AND location_type_id = OLD.location_type_id 
          AND end_date IS NULL;
          
        INSERT INTO civicrm_contacthistory_phone (
          contact_id, location_type_id, is_primary, is_billing,
          mobile_provider_id, phone, phone_ext, phone_numeric, phone_type_id
        ) VALUES (
          NEW.contact_id, NEW.location_type_id, NEW.is_primary, NEW.is_billing,
          NEW.mobile_provider_id, NEW.phone, NEW.phone_ext, NEW.phone_numeric, NEW.phone_type_id
        );
      END
    ";
    CRM_Core_DAO::executeQuery($sql);

    // Delete trigger
    $sql = "
      CREATE TRIGGER tr_phone_delete_history
      AFTER DELETE ON civicrm_phone
      FOR EACH ROW
      BEGIN
        UPDATE civicrm_contacthistory_phone 
        SET end_date = NOW() 
        WHERE contact_id = OLD.contact_id 
          AND location_type_id = OLD.location_type_id 
          AND end_date IS NULL;
      END
    ";
    CRM_Core_DAO::executeQuery($sql);
  }

}

