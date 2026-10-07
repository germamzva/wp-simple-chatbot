# WP Simple Chatbot

This repository now includes a cleaner WordPress plugin implementation with improved security and maintainability.

## What changed

- Added a plugin entry file: `wp-simple-chatbot.php`
- Split the code into reusable classes under `includes/`
- Moved frontend CSS and JS into `assets/`
- Added nonce and AJAX validation for chat submissions
- Added safer data handling and JSON-based conversation storage
- Updated the SQL schema for easier long-term maintenance

## Install

1. Copy the plugin folder into `wp-content/plugins/`
2. Activate the plugin in the WordPress admin dashboard
3. Add the shortcode to a page or post:

```php
[mortgage_broker_chatbot]
```

## Notes

- The shortcode is designed to work as a WordPress plugin instead of a one-off theme snippet.
- The AJAX endpoint now validates requests and rejects empty or malformed data.
- Database storage is compatible with a modern `message_data` table while also checking for the legacy table format.

## Database schema

The SQL file `name_your_own_here.sql` includes the recommended schema for storing chat conversations in a more flexible format.
