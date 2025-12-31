<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'district_id',
        'gn_division_id',
        'blood_group',
        'marital_status',
        'occupation',
        'height',
        'weight',
        'past_surgeries',
        'past_surgeries_details',
        'emergency_person',
        'preferred_language',
        'emergency_relationship',
        'address',
        'emergency_contact',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID on creation
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function ehrRecords()
    {
        return $this->hasMany(EhrRecord::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function gnDivision()
    {
        return $this->belongsTo(GnDivision::class, 'gn_division_id');
    }
}
