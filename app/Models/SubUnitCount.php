<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubUnitCount extends Model
{
    //relation of unit_count and sub_unit_count
    public function unitCounts()
    {
        return $this->belongsTo('App\Models\UnitCount','unit_count_id');
    }


}
