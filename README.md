# Contact History Extension

This CiviCRM extension tracks historical changes to contact addresses, emails, and phone numbers using database triggers.

## Features

- **Automatic History Tracking**: Uses database triggers to automatically capture changes when addresses, emails, or phone numbers are added, updated, or deleted
- **Dedicated History Tables**: Creates separate history tables that mirror the original structure but without foreign key constraints
- **Contact History Tab**: Adds a new tab to contact view showing complete history for addresses, emails, and phones
- **Permission-Based Management**: Edit and delete functionality restricted to users with appropriate permissions
- **API Support**: Full API3 and API4 compatibility for integration with other systems
- **SearchKit Compatible**: History data can be used in SearchKit searches and displays

## Requirements

- CiviCRM 6.0 or higher
- PHP 8.2, 8.3, or 8.4
- MySQL/MariaDB with trigger support

## Installation

1. Download the extension to your CiviCRM extensions directory
2. Enable the extension through Administer > System Settings > Extensions
3. History tables will be created and populated with current data automatically

## Usage

### Viewing History

1. Navigate to any contact record
2. Click the "Contact History" tab
3. View address, email, and phone history with start/end dates

### Managing History

Users with "Manage Contact History" permission can:
- Edit historical records
- Delete historical records
- View complete change timeline

### API Access

The extension provides API3 and API4 entities:
- `ContacthistoryAddress`
- `ContacthistoryEmail` 
- `ContacthistoryPhone`

Example API4 usage:
```php
$history = \Civi\Api4\ContacthistoryAddress::get()
  ->addWhere('contact_id', '=', 123)
  ->addOrderBy('start_date', 'DESC')
  ->execute();
```

## Permissions

- **View Contact History**: Included with standard contact view permissions
- **Manage Contact History**: Required to edit/delete history records (defaults to admin only)

## Database Structure

The extension creates three history tables:
- `civicrm_contacthistory_address`
- `civicrm_contacthistory_email`
- `civicrm_contacthistory_phone`

Each table includes:
- All original table fields (without foreign keys)
- `start_date`: When the record was created
- `modified_date`: When the record was last modified  
- `end_date`: When the record was deleted/replaced

## Technical Notes

- Database triggers are created using PHP code in the Upgrader class to avoid CiviCRM SQL file parsing issues with DELIMITER statements
- History tracking is implemented at the database level for reliability and performance
- The extension properly handles enable/disable cycles and clean uninstallation

## Troubleshooting

### Common Issues

1. **Triggers not working**: Ensure your database user has CREATE TRIGGER privileges
2. **Missing history tab**: Clear CiviCRM caches and check permissions
3. **Edit/delete buttons not working**: Verify "Manage Contact History" permission is assigned

### Debugging

- Check CiviCRM logs for SQL errors during installation
- Verify triggers exist using `SHOW TRIGGERS` in MySQL
- Confirm history tables contain expected data

## Support

Report issues and contribute at: https://github.com/kenmoellman/civicrm-contacthistory

## License

This extension is licensed under AGPL-3.0.
