<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WelfareContribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'welfare_benevolence_case_id',
        'member_id',
        'amount',
        'payment_type',
        'payment_date',
        'recorded_by',
    ];

    /**
     * Get the benevolence case that this contribution belongs to.
     */
    public function case(): BelongsTo
    {
        return $this->belongsTo(WelfareBenevolenceCase::class, 'welfare_benevolence_case_id');
    }

    /**
     * Get the member who made the contribution.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(WelfareMember::class, 'member_id');
    }

    /**
     * Get the user (admin) who recorded the contribution.
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}