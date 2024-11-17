<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras';

    protected $fillable = [
        'name',
        'email',
        'jenis_kelamin',
        'umur',
    ];

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_mitra')
            ->withPivot('user_id', 'posisi')
            ->withTimestamps();
    }

    public function getJumlahSurveiAttribute()
    {
        return $this->surveys()->count();
    }

    public function getSurveiAktifAttribute()
    {
        return $this->surveys()->where('start_date', '<=', now())->where('end_date', '>=', now())->count();
    }

    public function getPenanggungJawab(Survey $survey)
    {
        return $this->surveys()
            ->where('survey_id', $survey->id)
            ->first()
            ->pivot
            ->user;
    }
}
