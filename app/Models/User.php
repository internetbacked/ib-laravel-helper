<?php

namespace Ib\LaravelHelper\Models;

use Ib\LaravelHelper\Models\Eloquent\User as Model;

class User extends Model{
 public function posts()
 {
  return $this->hasMany(Post::class, 'post_author');
 }

 public function comments()
 {
  return $this->hasMany(Comment::class, 'user_id');
 }

 public function shop_orders()
 {
 	return $this->hasMany(ShopOrder::class, 'post_author');
 }
}
