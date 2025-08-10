-- Insert current data into history tables
INSERT INTO civicrm_contacthistory_address (
  contact_id, location_type_id, is_primary, is_billing, street_address,
  street_number, street_number_suffix, street_number_predirectional,
  street_name, street_type, street_number_postdirectional, street_unit,
  supplemental_address_1, supplemental_address_2, supplemental_address_3,
  city, county_id, state_province_id, postal_code_suffix, postal_code,
  usps_adr_dp, country_id, geo_code_1, geo_code_2, manual_geo_code,
  timezone, name, master_id
)
SELECT 
  contact_id, location_type_id, is_primary, is_billing, street_address,
  street_number, street_number_suffix, street_number_predirectional,
  street_name, street_type, street_number_postdirectional, street_unit,
  supplemental_address_1, supplemental_address_2, supplemental_address_3,
  city, county_id, state_province_id, postal_code_suffix, postal_code,
  usps_adr_dp, country_id, geo_code_1, geo_code_2, manual_geo_code,
  timezone, name, master_id
FROM civicrm_address;

INSERT INTO civicrm_contacthistory_email (
  contact_id, location_type_id, email, is_primary, is_billing,
  on_hold, is_bulkmail, hold_date, reset_date,
  signature_text, signature_html
)
SELECT 
  contact_id, location_type_id, email, is_primary, is_billing,
  on_hold, is_bulkmail, hold_date, reset_date,
  signature_text, signature_html
FROM civicrm_email;

INSERT INTO civicrm_contacthistory_phone (
  contact_id, location_type_id, is_primary, is_billing,
  mobile_provider_id, phone, phone_ext, phone_numeric, phone_type_id
)
SELECT 
  contact_id, location_type_id, is_primary, is_billing,
  mobile_provider_id, phone, phone_ext, phone_numeric, phone_type_id
FROM civicrm_phone;
