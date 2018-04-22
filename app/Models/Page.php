<?php

namespace Ib\LaravelHelper\Models;

use Ib\LaravelHelper\Models\Eloquent\Post as Model;

class Page extends Model{

 public function getPostType()
 {
  return 'page';
 }
}