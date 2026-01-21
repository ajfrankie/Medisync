<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EhrRecord extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'diagnosis',
        'treatment_summary',
        'next_visit_date'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    //releatioships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function vital()
    {
      return $this->hasOne(Vital::class, 'ehr_id')->latest('recorded_at');
    }

    // public function prescriptions()
    // {
    //     return $this->hasMany(Prescription::class, 'ehr_id');
    // }

    public function findByID($id)
    {
        return SupportiveDocument::where('id', $id)->first();
    }
}
