<?php
namespace Ib\LaravelHelper\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model{
	protected $primaryKey = 'order_item_id';
	public $timestamps = false;

	public function __construct(array $attributes = [])
	{
		global $wpdb;

		parent::__construct($attributes);

		$this->table = "{$wpdb->prefix}woocommerce_order_items";
	}

	public function order()
	{
		return $this->belongsTo(ShopOrder::class, 'order_id');
	}

	public function order_item_metas()
	{
		return $this->hasMany(OrderItemMeta::class, 'order_item_id');
	}
}
