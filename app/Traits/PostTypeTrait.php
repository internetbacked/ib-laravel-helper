<?php

namespace Ib\LaravelHelper\Traits;

use Ib\LaravelHelper\Models\Eloquent\Scopes\PostTypeScope;

trait PostTypeTrait
{

 /**
  * Boot the soft deleting trait for a model.
  *
  * @return void
  */
 public static function bootPostTypeTrait()
 {
  static::addGlobalScope(new PostTypeScope);
 }

 /**
  * @return string
  */
 public function getPostType()
 {
  return 'post';
 }
}