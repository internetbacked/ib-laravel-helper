<?php defined('ABSPATH') or die('Bye');
/**
 * Plugin Name:     WP Hybrid Laravel
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     laravel hybrid in wordpress
 * Author:          InternetBacked
 * Author URI:      https://internetbacked.com
 * Text Domain:     ib-laravel-helpers
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Ib_Laravel_Helpers
 */

global $wp_hybrid_laravel;

define('WPHL_PLUGIN', __FILE__);
define('WPHL_PLUGIN_DIR', __DIR__);

if(!class_exists('Dotenv\Dotenv'))
{
 shell_exec("php composer.phar install");
 return;
}

$wp_hybrid_laravel = require_once WPHL_PLUGIN_DIR.'/bootstrap/app.php';
