<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'slug',
        'registration_number',
        'established_year',
        'logo',
        'description',
        'country',
        'province',
        'city',
        'address',
        'official_email',
        'phone',
        'website',
        'custom_subdomain',
        'whatsapp',
        'twitter',
        'facebook',
        'plan_id',
        'status',
        'trial_ends_at',
        'billing_cycle',
        'trial_days',
        'max_students',
        'max_teachers',
        'storage_gb',
        'custom_mrr',
        'tags',
        'feature_toggles',
        'internal_notes',
        'account_manager_id',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'tags' => 'array',
        'feature_toggles' => 'array',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function primaryDomain(): HasOne
    {
        return $this->hasOne(Domain::class)->where('type', 'subdomain');
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Campus::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function accountManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    public function isTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function trialDaysLeft(): int
    {
        return $this->trial_ends_at ? (int) now()->diffInDays($this->trial_ends_at, false) : 0;
    }
}
