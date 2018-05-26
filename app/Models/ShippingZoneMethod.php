<?php
namespace Ib\LaravelHelper\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZoneMethod extends Model{
	public function __construct(array $attributes = [])
	{
		global $wpdb;

		parent::__construct($attributes);

		$this->table = "{$wpdb->prefix}woocommerce_shipping_zone_methods";
	}

	public static function options()
	{
		return collect(self::all()->map(function($zone)
		{
			return [
					"{$zone->method_id}:{$zone->instance_id}" => title_case(str_replace('_', ' ', $zone->method_id))
			];
		}));
	}
}
