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

if(class_exists('Dotenv\Dotenv')) return;
if(class_exists('Illuminate\Foundation\Application')) return;

global $wp_hybrid_laravel;

require_once(WPHL_PLUGIN_DIR.'/includes/helpers-override.php');

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));


/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require_once(WPHL_PLUGIN_DIR.'/vendor/autoload.php');

try {
    (new Dotenv\Dotenv(ABSPATH))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it.
|
*/

$wp_hybrid_laravel = require_once WPHL_PLUGIN_DIR.'/bootstrap/app.php';

app()->useStoragePath(ABSPATH.'storage');
