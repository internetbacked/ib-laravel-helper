<?php
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Classes\Cache;
use Maatwebsite\Excel\Classes\FormatIdentifier;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use Maatwebsite\Excel\Classes\PHPExcel;
use Illuminate\Contracts\Bus\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Contracts\Bus\QueueingDispatcher as QueueingDispatcherContract;
use Illuminate\Bus\Dispatcher;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

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

$wp_hybrid_laravel->instance('path.storage', ABSPATH.'/wp-content/uploads');

//Load Config
$wp_hybrid_laravel['config']->set('database', require WPHL_PLUGIN_DIR.'/config/database.php');
$wp_hybrid_laravel['config']->set('mail', require WPHL_PLUGIN_DIR.'/config/mail.php');

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


PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_APPROX);

$wp_hybrid_laravel->singleton(Dispatcher::class, function ($app) {
	return new Dispatcher($app, function ($connection = null) use ($app) {
		return $app[QueueFactoryContract::class]->connection($connection);
	});
});

$wp_hybrid_laravel->alias(
	Dispatcher::class, DispatcherContract::class
);

$wp_hybrid_laravel->alias(
	Dispatcher::class, QueueingDispatcherContract::class
);

// Bind the PHPExcel class
$wp_hybrid_laravel->singleton('phpexcel', function ()
{
	// Set locale
	PHPExcel_Settings::setLocale('en_us');

	// Set the caching settings
	(new Cache());

	// Init phpExcel
	$excel = new PHPExcel();
	$excel->setDefaultProperties();
	return $excel;
});

$wp_hybrid_laravel->singleton('excel.identifier', function ($app)
{
	return new FormatIdentifier($app['files']);
});

// Bind the laravel excel reader
$wp_hybrid_laravel->singleton('excel.reader', function ($app)
{
	return new LaravelExcelReader(
		$app['files'],
		$app['excel.identifier'],
		$app['Illuminate\Contracts\Bus\Dispatcher']
	);
});

// Bind the excel writer
$wp_hybrid_laravel->singleton('excel.writer', function ($app)
{
	return new LaravelExcelWriter(
		$app->make(Response::class),
		$app['files'],
		$app['excel.identifier']
	);
});

// Bind the Excel class and inject its dependencies
$wp_hybrid_laravel->singleton('excel', function ($app)
{
	$excel = new Excel(
		$app['phpexcel'],
		$app['excel.reader'],
		$app['excel.writer']
	);

	$excel->registerFilters([]);

	return $excel;
});

$wp_hybrid_laravel->alias('excel', Excel::class);

return $wp_hybrid_laravel;
