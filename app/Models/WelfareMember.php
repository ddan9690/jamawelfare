<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelfareMember extends Model
{
    protected $fillable = [
        'user_id',
        'welfare_id',
        'member_number',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function welfare()
    {
        return $this->belongsTo(Welfare::class);
    }

    public function contributions()
    {
        return $this->hasMany(WelfareContribution::class, 'member_id');
    }
}
