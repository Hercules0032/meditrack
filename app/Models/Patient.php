<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dob',
        'gender',
        'phone',
        'address',
        'blood_group',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalReports(): HasMany
    {
        return $this->hasMany(MedicalReport::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(fn () => $this->user?->name ?? '');
    }

    protected function age(): Attribute
    {
        return Attribute::get(fn () => $this->dob ? Carbon::parse($this->dob)->age : null);
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value ? preg_replace('/\D/', '', $value) : $value,
        );
    }
}
