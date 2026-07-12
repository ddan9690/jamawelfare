<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolidarityFund extends Model
{
    protected $fillable = [
        'welfare_member_id',
        'amount',
        'type',
        'payment_method',
        'transaction_date',
        'welfare_benevolence_case_id',
        'description',
        'reference_number',
        'created_by'
    ];
    
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'date',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(WelfareMember::class, 'welfare_member_id');
    }

    public function benevolenceCase(): BelongsTo
    {
        return $this->belongsTo(WelfareBenevolenceCase::class, 'welfare_benevolence_case_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
