<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
  protected $guarded = [];
  protected $table = 'products';

  public function category()
  {
    return $this->belongsTo('App\Models\Category','category_id','id');
  }

  public function unit()
  {
    return $this->belongsTo('App\Models\Units','unit_id','id');
  }

    public function Expired(){
        return $this->hasMany('App\Models\Expired_Date','product','id');
    }
}

