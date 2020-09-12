<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    public function ads(){
        return $this->belongsTo(Ads::class);
    }
}
