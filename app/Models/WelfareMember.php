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

    public function solidarityFunds()
    {
        return $this->hasMany(SolidarityFund::class);
    }

    public function getSolidarityBalanceAttribute()
    {
        $deposits = $this->solidarityFunds()->where('type', 'deposit')->sum('amount');
        $deductions = $this->solidarityFunds()->where('type', 'deduction')->sum('amount');

        return $deposits - $deductions;
    }
}
