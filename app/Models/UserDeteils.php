<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeteils extends Model
{
    use HasFactory;

    protected $table = 'user_details';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function country()
    {
        return $this->hasOne('App\Country','id', 'citizenship_country_id');
    }
}
