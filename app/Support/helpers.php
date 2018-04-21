<?php

use Philo\Blade\Blade;
use Collective\Html\HtmlBuilder;
use Collective\Html\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Config\Repository as Config;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\SessionManager;
use Illuminate\Log\Writer;
use Monolog\Logger;


/**
 * @param string $message
 * @param string $type
 */
function logger($message, $type = 'info')
{
 $log = new Writer(new Logger('WPHL'));

 $log->useFiles(ABSPATH . 'wphl.log');

 $log->{$type}("{$message}");
}

function session()
{
 global $wp_hybrid_laravel;

 return $wp_hybrid_laravel['session'];
}


/**
 * @return Blade
 */
function blade()
{
 $views = defined('WPHL_RESOURCES_VIEWS')
  ? WPHL_RESOURCES_VIEWS
  : WPHL_PLUGIN_DIR . '/resources/views';

 $cache = WPHL_PLUGIN_DIR . '/resources/cache';

 return new Blade($views, $cache);
}

/**
 * @param $view
 * @param $data
 * @return mixed
 */
function render($view, $data)
{
 return blade()->view()->make($view, $data)->render();
}

/**
 * @param string $uri
 * @return string
 */
function app_url($uri='')
{
 $app_url = env('APP_URL');

 return "{$app_url}{$uri}";
}

/**
 * @return static
 */
function request()
{
 return Request::capture();
}

/**
 * @return Router
 */
function router()
{
 global $wp_hybrid_laravel;

 return new Router(data_get($wp_hybrid_laravel, 'events'));
}

/**
 * @return UrlGenerator
 */
function url()
{
 return new UrlGenerator(router()->getRoutes(), request());
}

/**
 * @return HtmlBuilder
 */
function html()
{
 return new HtmlBuilder(url());
}

/**
 * @return FormBuilder
 */
function form()
{
 global $wp_hybrid_laravel;

 return new FormBuilder(html(), url(), $wp_hybrid_laravel['session.store']);
}

function back()
{
 if($referer = request()->headers->get('referer'))
  if(empty($referer))
    return false;

 $_http_method = 'get'; //TODO: track previous method somewhere and retreive here
 $last_method = strtolower($_http_method ? $_http_method : 'post');

 if(request()->input('_token'))
 {
  echo form()->open(['url' => $referer, 'files' => true, 'method' => $last_method]);

  foreach(request()->except(['submit']) as $field_name => $field_value)
  {
   echo form()->input('hidden', $field_name, $field_value);
  }

  echo form()->close();
  echo "<script>document.forms[0].submit()</script>";
  exit;
 }else
 {
  echo "<script>window.history.back()</script>";
  exit;
 }

}


if (! function_exists('env')) {
 /**
  * Gets the value of an environment variable.
  *
  * @param  string  $key
  * @param  mixed   $default
  * @return mixed
  */
 function env($key, $default = null)
 {
  $value = getenv($key);

  if ($value === false) {
   return value($default);
  }

  switch (strtolower($value)) {
   case 'true':
   case '(true)':
    return true;
   case 'false':
   case '(false)':
    return false;
   case 'empty':
   case '(empty)':
    return '';
   case 'null':
   case '(null)':
    return;
  }

  if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
   return substr($value, 1, -1);
  }

  return $value;
 }
}

/**
 * @return Container
 */
function container()
{
 $app           = new Container();
 $app['events'] = new Dispatcher();
 $app['config'] = new Config(require WPHL_PLUGIN_DIR . '/config/app.php');
 $app['files']  = new Filesystem;
 $app['config']['session.files'] = WPHL_PLUGIN_DIR . '/storage/framework/sessions';
 $sessionManager = new SessionManager($app);
 $app['session.store'] = $sessionManager->driver();
 $app['session'] = $sessionManager;

 // In order to maintain the session between requests, we need to populate the
 // session ID from the supplied cookie
 $cookieName = $app['session']->getName();
 if (isset($_COOKIE[$cookieName])) {
  if ($sessionId = $_COOKIE[$cookieName]) {
   $app['session']->setId($sessionId);
  }
 }

 // Boot the session
 $app['session']->start();

 return $app;
}
