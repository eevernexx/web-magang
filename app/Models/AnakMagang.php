<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnakMagang extends Model
{
    protected $table = 'anak_magangs';

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
