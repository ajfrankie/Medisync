<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class SupportiveDocument extends Model
{
    protected $fillable = [
        'id',
        'patient_id',
        'title',
        'file_path',
        'description',
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

    // Relation to Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
