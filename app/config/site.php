<?php
/**
 * Site Configuration & Feature Flags
 */

// Toggle Switch for Public Marketing Website
// Set to false to hide public website (redirects visitors to management portal login).
// Set to true when officially launching the public website.
if (!defined('SHOW_PUBLIC_WEBSITE')) {
    define('SHOW_PUBLIC_WEBSITE', false);
}
