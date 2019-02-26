<?php defined('ABSPATH') or die('Bye');
/**
 * Plugin Name:     WP Hybrid Laravel
 * Plugin URI:      https://github.com/internetbacked/ib-laravel-helper
 * Description:     laravel hybrid in wordpress
 * Author:          InternetBacked
 * Author URI:      https://internetbacked.com
 * Text Domain:     ib-laravel-helper
 * Domain Path:     /languages
 * Version:         1.2.2
 *
 * @package         Ib_Laravel_Helper
 */

global $wp_hybrid_laravel;

define('WPHL_PLUGIN', __FILE__);
define('WPHL_PLUGIN_DIR', __DIR__);

$wp_hybrid_laravel = require_once WPHL_PLUGIN_DIR.'/bootstrap/app.php';
