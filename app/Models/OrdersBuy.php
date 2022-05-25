<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersBuy extends Model
{
    
    protected $table = 'orders_bay';
    protected $guarded = [];

    public function Details(){
        return $this->hasMany('App\Models\DetailsOrder','order_id','id');
    }
    public function Customer(){
        return $this->hasMany('App\Models\Customer','id','customer');
    }
    public function User(){
        return $this->hasMany('App\User','id','user');
    }
    public function UserDelete(){
        return $this->hasMany('App\User','id','user_del');
    }
}
