<?php

namespace Ib\LaravelHelper\Models\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class PostTypeScope implements ScopeInterface
{
 protected $column = 'post_type';

 /**
  * Apply the scope to a given Eloquent query builder.
  *
  * @param  \Illuminate\Database\Eloquent\Builder  $builder
  * @param  \Illuminate\Database\Eloquent\Model  $model
  * @return void
  */
 public function apply(Builder $builder, Model $model)
 {
  $post_type = $model->getPostType();

  if(!empty($post_type) && $post_type!='any')
   $builder->where($this->column, '=', $post_type);
 }

 /**
  * Remove the scope from the given Eloquent query builder.
  *
  * @param  \Illuminate\Database\Eloquent\Builder  $builder
  * @param  \Illuminate\Database\Eloquent\Model  $model
  * @return void
  */
 public function remove(Builder $builder, Model $model)
 {
  $query = $builder->getQuery();

  foreach ((array) $query->wheres as $key => $where)
  {
   // If the where clause is a soft delete date constraint, we will remove it from
   // the query and reset the keys on the wheres. This allows this developer to
   // include deleted model in a relationship result set that is lazy loaded.
   if ($key == $this->column)
   {
    unset($query->wheres[$key]);

    $query->wheres = array_values($query->wheres);
   }
  }
 }
}