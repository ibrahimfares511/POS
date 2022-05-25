<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $guarded = [];
    protected $table = 'employees';
    public function Jobs()
    {
      return $this->belongsTo('App\Models\Jobs','job','id');
    }

    public function Atendance(){
      return $this->hasMany('App\Models\Atendance','employee','id');
    }
}
