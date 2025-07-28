<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormUser extends Model
{
    protected $fillable = [
        'token',
    ];

    public function personalData()
    {
        return $this->hasOne(PersonalData::class);
    }

    public function answers()
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }
}
