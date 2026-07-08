<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelfareBenevolenceCase extends Model
{
    protected $fillable = [
        'welfare_id',
        'case_number', 
        'member_id',
        'benevolence_category_id',
        'amount_to_contribute',
        'deadline',
        'details',
        'status',
        'created_by'
    ];

    public function welfare()
    {
        return $this->belongsTo(Welfare::class, 'welfare_id');
    }

    public function member()
    {
        return $this->belongsTo(WelfareMember::class, 'member_id');
    }
    public function category()
    {
        return $this->belongsTo(BenevolenceCategory::class, 'benevolence_category_id');
    }

    public function contributions()
    {
        return $this->hasMany(WelfareContribution::class, 'welfare_benevolence_case_id');
    }
}
