<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormUser extends Model
{
    protected $fillable = [
        'token',
        'name',
        'email'
    ];

    protected $appends = ['name', 'email'];

    public function getNameAttribute()
    {
        return $this->personalData ? $this->personalData->full_name : null;
    }

    public function getEmailAttribute()
    {
        return $this->personalData ? $this->personalData->email : null;
    }

    public function personalData()
    {
        return $this->hasOne(PersonalData::class);
    }

    public function questionnaireAnswers()
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }
}
