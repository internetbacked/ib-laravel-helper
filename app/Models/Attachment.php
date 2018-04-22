<?php

namespace Ib\LaravelHelper\Models;

use Ib\LaravelHelper\Models\Eloquent\Post as Model;

class Attachment extends Model{
 public function getPostType()
 {
  return 'attachment';
 }
}