<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spending extends Model
{
    protected $guarded = [];
    protected $table = 'spending';
    public function Expenses()
    {
      return $this->belongsTo('App\Models\Expenses','expense','id');
    }

    public function Users()
    {
      return $this->belongsTo('App\User','user','id');
    }
}
