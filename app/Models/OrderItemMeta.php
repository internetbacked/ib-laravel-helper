<?php
namespace Ib\LaravelHelper\Models;

class OrderItemMeta extends Eloquent\Meta{
	public function __construct(array $attributes = [])
	{
		global $wpdb;

		parent::__construct($attributes);

		$this->table = "{$wpdb->prefix}woocommerce_order_itemmeta";
	}
}
