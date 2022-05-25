<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $guarded = [];
    protected $table = 'expenses';
    
    public function Spending(){
        return $this->hasMany('App\Models\Atendance','employee','id');
      }
}
