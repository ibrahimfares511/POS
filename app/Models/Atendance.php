<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendance extends Model
{
    protected $guarded = [];
    protected $table = 'atendance';

    public function Employee()
    {
      return $this->belongsTo('App\Models\Employees','employee','id');
    }
}
