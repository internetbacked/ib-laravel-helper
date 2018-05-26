<?php

use Ib\LaravelHelper\Models\OrderItemMeta;

function used_shipping_methods()
{
	if(!class_exists('WC_Order_Item_Shipping')) return collect([]);

	return OrderItemMeta::whereMetaKey('method_id')->groupBy('meta_value')->get()
		->map(function($item)
		{
			return new WC_Order_Item_Shipping($item->order_item_id);
		});
}

function used_shipping_method_options()
{
	return used_shipping_methods()->pluck('method_title', 'method_id');
}
