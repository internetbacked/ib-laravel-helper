<?php

namespace Ib\LaravelHelper\Models;

use Ib\LaravelHelper\Models\Eloquent\Post as Model;

class Product extends Model{
 public function getPostType()
 {
  return 'product';
 }
}