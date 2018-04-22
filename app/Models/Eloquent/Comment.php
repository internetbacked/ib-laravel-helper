<?php

namespace Ib\LaravelHelper\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
 protected $primaryKey = 'comment_ID';

 const CREATED_AT = 'comment_date';
 const UPDATED_AT = 'comment_date';

 public function __construct(array $attributes = [])
 {
  global $wpdb;

  parent::__construct($attributes);

  $this->table = $wpdb->comments;
 }
}