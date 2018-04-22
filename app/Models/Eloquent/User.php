<?php

namespace Ib\LaravelHelper\Models\Eloquent;

class User extends Base{
 const CREATED_AT = 'user_registered';
 const UPDATED_AT = 'user_registered';

 public function __construct(array $attributes = [])
 {
  global $wpdb;

  parent::__construct($attributes);

  $this->table = $wpdb->users;
 }
}