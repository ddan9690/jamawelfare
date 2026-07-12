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
        'status', // Ensure status is fillable if you use it
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

    /**
     * Get the current balance using a single, efficient query.
     * This calculates balance as: Deposits - Deductions
     */
    public function getSolidarityBalanceAttribute()
    {
        return $this->solidarityFunds()
            ->selectRaw("SUM(CASE WHEN type = 'deposit' THEN amount ELSE -amount END) as balance")
            ->value('balance') ?? 0;
    }
}