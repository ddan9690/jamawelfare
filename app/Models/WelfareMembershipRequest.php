<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelfareMembershipRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'welfare_id',
        'user_id',
        'status',
        'notes',
    ];

    /**
     * Get the user that owns the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the welfare that the request belongs to.
     */
    public function welfare()
    {
        return $this->belongsTo(Welfare::class);
    }
}