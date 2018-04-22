<?php

require_once WPHL_PLUGIN_DIR.'/app/Support/helpers.php';
require_once WPHL_PLUGIN_DIR.'/app/Support/helpers-override.php';

require_once WPHL_PLUGIN_DIR.'/vendor/autoload.php';

try {
(new Dotenv\Dotenv(ABSPATH))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
//
}

global $wp_hybrid_laravel;

$wp_hybrid_laravel = container();

//Load Config
$wp_hybrid_laravel['config']->set('database', require WPHL_PLUGIN_DIR.'/config/database.php');

//Load Database
$capsule = new Illuminate\Database\Capsule\Manager;

$capsule->addConnection(config('database.connections.mysql'));

// Set the event dispatcher used by Eloquent models... (optional)
$capsule->setEventDispatcher(new Illuminate\Events\Dispatcher($wp_hybrid_laravel));

// Set the cache manager instance used by connections... (optional)
// $capsule->setCacheManager(...);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

return $wp_hybrid_laravel;