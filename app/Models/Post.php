<?php

namespace Ib\LaravelHelper\Models;

use Ib\LaravelHelper\Models\Eloquent\Post as Model;

class Post extends Model{
 public function getPostType()
 {
  return 'post';
 }
}