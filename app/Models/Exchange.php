<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $guarded = [];
    protected $table = 'exchange';
    public function Customers()
    {
      return $this->belongsTo('App\Models\Customer','customer','id');
    }

    public function Users()
    {
      return $this->belongsTo('App\User','user','id');
    }

    public function UserDelete(){
      return $this->hasMany('App\User','id','del_user');
    }
}
