<?php

namespace Ib\LaravelHelper\Support;

use PHPExcel_Helper_HTML;
use WC_Order;
use WC_Product;

class DataPoslaju{
	public $address;
	public $contact;
	public $postcode;
	public $desc;

	//Extra Columns
	public $id;
	public $total;

	public function __construct(WC_Order $order)
	{
		//Column B
		$fullname = implode(' ', collect([
			$order->shipping_first_name,
			$order->shipping_last_name
		])->toArray());

		$shipping_address = implode(' ', collect([
			$order->shipping_company,
			$order->shipping_address_1,
			$order->shipping_address_2,
			$order->shipping_city,
			$order->shipping_postcode,
		])->reject(function($value){ return empty($value); })->toArray());

		if(empty($fullname))
			$fullname = '-';

		if(empty($shipping_address))
			$shipping_address = '-';

		$helper = new PHPExcel_Helper_HTML;
		$richtext = $helper->toRichTextObject("{$fullname}<br/>{$shipping_address}");

		//Column C
		$shipping_phone = get_post_meta($order->ID, 'shipping_phone', true);

		//Column D
		$shipping_postcode = $order->shipping_postcode;

		//Column E
		$sku_count = [];

		$order_items = $order->get_items();
		foreach($order_items as $order_item)
		{
			$product = new WC_Product($order_item['product_id']);
			$product_sku = $product->get_sku();
			$qty = $order_item['qty'];

			$sku_count[] = strtoupper("{$product_sku}x{$qty}");
		}

		$desc = implode(',', $sku_count);

		$this->address = $richtext;
		$this->contact = $shipping_phone;
		$this->postcode = $shipping_postcode;
		$this->desc = $desc;

		$this->id = $order->ID;
		$this->total = $order->get_total();
	}
}
