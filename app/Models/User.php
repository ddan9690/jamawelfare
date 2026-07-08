<?php

namespace App\Models;

use App\Models\County;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail; // Import the interface
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'gender', 
        'email',
        'phone',
        'tsc_number',
        'level',
        'county_id',
        'is_super_admin',
        'last_login_at',
        'email_verified_at', // Keep for compatibility
        'otp_verified_at',   // Add this to mass assignable
        'password',
        'otp',
        'otp_expires_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp', // Hide OTP for security
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- MustVerifyEmail Implementation ---

    public function hasVerifiedEmail()
    {
        return !is_null($this->otp_verified_at);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'otp_verified_at' => now(),
            'otp' => null,
        ])->save();
    }

    public function sendEmailVerificationNotification()
    {
        // Leaving empty: The Event/Listener system handles this via SendOtpVerification
    }

    // --- Relationships ---

    public function welfares()
    {
        return $this->belongsToMany(Welfare::class, 'welfare_members', 'user_id', 'welfare_id')
            ->withPivot('role');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function welfareMemberships()
    {
        return $this->hasMany(WelfareMember::class);
    }

    public function currentMembership()
    {
        return $this->welfareMemberships() // Corrected from non-existent memberships()
            ->where('welfare_id', session('active_welfare_id'))
            ->first();
    }
}