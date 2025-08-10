-- Triggers are dropped in PHP code via Upgrader::uninstall()

-- Drop tables
DROP TABLE IF EXISTS civicrm_contacthistory_address;
DROP TABLE IF EXISTS civicrm_contacthistory_email;
DROP TABLE IF EXISTS civicrm_contacthistory_phone;
