<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenevolenceCategory extends Model
{
    protected $fillable = ['welfare_id', 'name', 'amount', 'description'];

    public function welfare()
    {
        return $this->belongsTo(Welfare::class);
    }
}