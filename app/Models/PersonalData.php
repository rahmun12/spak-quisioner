<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $fillable = [
        'form_user_id',
        'full_name',
        'address',
        'birth_date',
        'service_type',
        'phone_number',
        'gender',
        'education',
        'occupation',
    ];

    public function formUser()
    {
        return $this->belongsTo(FormUser::class);
    }
}
