<?php

namespace Ib\LaravelHelper\Models;

use Ib\LaravelHelper\Models\Eloquent\Comment as Model;

class Comment extends Model{
 public function user()
 {
  return $this->belongsTo(User::class, 'user_id');
 }
}