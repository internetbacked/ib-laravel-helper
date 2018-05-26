<?php

namespace Ib\LaravelHelper\Models;

use WC_Order;
use Ib\LaravelHelper\Models\Eloquent\Post as Model;

class ShopOrder extends Model{
 public function getPostType()
 {
  return 'shop_order';
 }

 public function order_items()
 {
 	return $this->hasMany(OrderItem::class, 'order_id');
 }

 public function order_item_metas()
 {
 	return $this->hasManyThrough(OrderItemMeta::class, OrderItem::class, 'order_id');
 }

 public function toArray()
 {
 	if(class_exists('WC_Order'))
	{
		return new WC_Order($this->ID);
	}

	return parent::toArray();
 }
}
