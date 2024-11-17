<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyMitra extends Model
{
    protected $table = 'survey_mitra';
    
    protected $fillable = ['survey_id', 'mitra_id', 'user_id', 'posisi'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
