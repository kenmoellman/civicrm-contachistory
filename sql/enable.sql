-- Insert current data into history tables (only if history tables are empty)
INSERT INTO civicrm_contacthistory_address (
  original_id, contact_id, location_type_id, is_primary, is_billing, 
  street_address, supplemental_address_1, supplemental_address_2, 
  city, state_province_id, postal_code, country_id, 
  geo_code_1, geo_code_2, manual_geo_code
)
SELECT 
  id, contact_id, location_type_id, is_primary, is_billing,
  street_address, supplemental_address_1, supplemental_address_2,
  city, state_province_id, postal_code, country_id,
  geo_code_1, geo_code_2, manual_geo_code
FROM civicrm_address
WHERE NOT EXISTS (SELECT 1 FROM civicrm_contacthistory_address LIMIT 1);

INSERT INTO civicrm_contacthistory_email (
  original_id, contact_id, location_type_id, email, is_primary, is_billing,
  on_hold, is_bulkmail, hold_date, reset_date
)
SELECT 
  id, contact_id, location_type_id, email, is_primary, is_billing,
  on_hold, is_bulkmail, hold_date, reset_date
FROM civicrm_email
WHERE NOT EXISTS (SELECT 1 FROM civicrm_contacthistory_email LIMIT 1);

INSERT INTO civicrm_contacthistory_phone (
  original_id, contact_id, location_type_id, is_primary, is_billing,
  phone, phone_ext, phone_numeric, phone_type_id
)
SELECT 
  id, contact_id, location_type_id, is_primary, is_billing,
  phone, phone_ext, phone_numeric, phone_type_id
FROM civicrm_phone
WHERE NOT EXISTS (SELECT 1 FROM civicrm_contacthistory_phone LIMIT 1);

