<?php defined('ABSPATH') or die('Bye');

if (! function_exists('config')) {
    /**
     * WARNING: NOT WORK
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        return null;
    }
}

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return mixed|\Illuminate\Foundation\Application
     */
    function app($abstract = null, array $parameters = [])
    {
     global $wp_hybrid_laravel;

        if (is_null($abstract)) {
            return $wp_hybrid_laravel;
        }
        return empty($parameters)
            ? $wp_hybrid_laravel->make($abstract)
            : $wp_hybrid_laravel->makeWith($abstract, $parameters);
    }
}
