<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{

    protected $fillable = [
        'user_id', 'token',
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }
}
