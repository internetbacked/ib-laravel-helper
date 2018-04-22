<?php

namespace Ib\LaravelHelper\Models\Eloquent;

use Ib\LaravelHelper\Traits\PostTypeTrait;

class Post extends Base{
 use PostTypeTrait;

 const CREATED_AT = 'post_date';
 const UPDATED_AT = 'post_modified';

 public function __construct(array $attributes = [])
 {
  global $wpdb;

  parent::__construct($attributes);

  $this->table = $wpdb->posts;
 }
}