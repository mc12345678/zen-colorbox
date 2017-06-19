/* Tables need to be ensured to include the prefix if it exists and these are run through phpMyAdmin. */


SELECT @ZCBgID := configuration_group_id
FROM configuration_group where configuration_group_title = 'Zen Colorbox Config';

DELETE FROM configuration WHERE configuration_group_id = @ZCBgID;

DELETE FROM admin_pages WHERE page_key = 'configZenColorbox';

DELETE FROM configuration_group WHERE configuration_group_id = @ZCBgID;