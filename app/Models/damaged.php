<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class damaged extends Model
{
    protected $table = 'damaged';
    protected $guarded = [];

    public function category()
    {
      return $this->belongsTo('App\Models\Category','category_id','id');
    }
  
    public function unit()
    {
      return $this->belongsTo('App\Models\Units','unit_id','id');
    }
}
