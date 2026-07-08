<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Welfare extends Model
{
    protected $fillable = [
        'name',
        'abbreviation',
        'county_id',
        'status',
        'description',
        'slug',
        'logo'
    ];

    // --- ADD THIS METHOD ---
    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function members()
    {
        return $this->hasMany(WelfareMember::class);
    }

    public function membershipRequests()
    {
        return $this->hasMany(WelfareMembershipRequest::class);
    }

    public function benevolenceCases()
    {
        // Ensure this points to the correct class name: WelfareBenevolenceCase
        return $this->hasMany(WelfareBenevolenceCase::class, 'welfare_id');
    }

    protected static function booted()
    {
        static::creating(function ($welfare) {
            $welfare->slug = Str::slug($welfare->name);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
