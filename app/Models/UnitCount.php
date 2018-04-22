<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitCount extends Model
{
//    relation of unit_count and sub_unit_count
    public function subUnits()
    {
        return $this->hasMany('App\Models\SubUnitCount','unit_count_id');
    }
}
