<?php

require_once WPHL_PLUGIN_DIR.'/app/Support/helpers.php';
require_once WPHL_PLUGIN_DIR.'/app/Support/helpers-override.php';

require_once WPHL_PLUGIN_DIR.'/vendor/autoload.php';

try {
(new Dotenv\Dotenv(ABSPATH))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
//
}

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
"driver" => env('DB_CONNECTION', 'mysql'),
"host" => env('DB_HOST', DB_HOST),
"database" => env('DB_DATABASE', DB_NAME),
"username" => env('DB_USERNAME', DB_USER),
"password" => env('DB_PASSWORD', DB_PASSWORD)
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

return container();