<?php

namespace Ib\LaravelHelper\Support;

use PHPExcel_Helper_HTML;
use WC_Order;
use WC_Product;

class DataPoslaju2019{

	protected $data = [];

	public function __construct(WC_Order $order)
	{
		// Receiver Name
		$fullname = implode(' ', [
			$order->shipping_first_name,
			$order->shipping_last_name
		]);

		if(empty($fullname))
			$fullname = '-';

		// Receiver Contact
		$shipping_phone = get_post_meta($order->ID, 'shipping_phone', true);

		// Item Description
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

		$this->data = [
			// Sender Name
			'',

			// Sender Company Name
			'',

			// Sender Email
			'',

			// Sender Contact Number
			'',

			// Sender Alternative Contact Number
			'',

			// Sender Address 1
			'',

			// Sender Address 2
			'',

			// Sender Address 3
			'',

			// Sender Address 4
			'',

			// Sender City
			'',

			// Sender State
			'',

			// Sender Country
			'',

			// Sender Postcode
			'',

			// Receiver Name
			$fullname,

			// Receiver Company Name
			$order->shipping_company,

			// Receiver Email
			'',

			// Receiver Contact Number
			$shipping_phone,

			// Receiver Alternative Contact Number
			'',

			// Receiver Address 1
			$order->shipping_address_1,

			// Receiver Address 2
			$order->shipping_address_2,

			// Receiver Address 3
			'',

			// Receiver Address 4
			'',

			// Receiver City
			$order->shipping_city,

			// Receiver State
			$order->shipping_state,

			// Receiver Country
			$order->shipping_country,

			// Receiver Postcode
			$order->shipping_postcode,

			// Item Weight kg
			'',

			// Item Width cm
			'',

			// Item Length cm
			'',

			// Item Height cm
			'',

			// Item Description
			$desc,

			// COD Amount
			'',

			// CCOD Amount
			'',

			// Shipper Ref No
			'',

			// Recipient Ref No
			'',

			// Insurance
			'',

			// Sum Insured
			''
		];
	}

	public function getData() {
		return $this->data;
	}

	public static function getHeader() {
		return [
			'Sender Name',
			'Sender Company Name',
			'Sender Email',
			'Sender Contact Number',
			'Sender Alternative Contact Number',
			'Sender Address 1',
			'Sender Address 2',
			'Sender Address 3',
			'Sender Address 4',
			'Sender City',
			'Sender State',
			'Sender Country',
			'Sender Postcode',
			'Receiver Name',
			'Receiver Company Name',
			'Receiver Email',
			'Receiver Contact Number',
			'Receiver Alternative Contact Number',
			'Receiver Address 1',
			'Receiver Address 2',
			'Receiver Address 3',
			'Receiver Address 4',
			'Receiver City',
			'Receiver State',
			'Receiver Country',
			'Receiver Postcode',
			'Item Weight kg',
			'Item Width cm',
			'Item Length cm',
			'Item Height cm',
			'Item Description',
			'COD Amount',
			'CCOD Amount',
			'Shipper Ref No',
			'Recipient Ref No',
			'Insurance',
			'Sum Insured'
		];
	}
}
