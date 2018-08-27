<?php

namespace Ib\LaravelHelper\Models;

use Illuminate\Database\Eloquent\Builder;
use WC_Order;
use WC_Product;
use WP_Post;
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

 public function scopeHasProduct(Builder $query, $product)
 {
 	if($product instanceof WP_Post)
 		$product = new WC_Product($product->ID);

 	return $query->whereHas('order_item_metas', function($query)
		use ($product)
	{
		$query->whereMetaKey('_product_id')->whereMetaValue($product->get_id());
	});
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
