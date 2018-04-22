<?php

namespace Ib\LaravelHelper\Models;

use Ib\LaravelHelper\Models\Eloquent\Post as Model;

class ShopOrder extends Model{
 public function getPostType()
 {
  return 'shop_order';
 }
}