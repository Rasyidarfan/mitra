<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';

    protected $fillable = [
        'name',
        'alias',
        'start_date',
        'end_date',
        'mitra',
        'team_id',
    ];

    // Relationship dengan Role
    public function team()
    {
        return $this->belongsTo(Role::class, 'team_id', 'id');
    }

    public function getMitrasDetail()
    {
        return $this->hasMany(SurveyMitra::class, 'survey_id')
            ->join('mitras', 'survey_mitra.mitra_id', '=', 'mitras.id')
            ->join('users', 'survey_mitra.pj_id', '=', 'users.id')
            ->select(['mitras.id','mitras.name','mitras.email','survey_mitra.posisi','users.name as pj'])
            ->orderBy('survey_mitra.posisi')->orderBy('mitras.name')->get();
    }

    public function getMitrasUnregistered()
    {
        return Mitra::whereNotIn('id', function($query) {
            $query->select('mitra_id')
                  ->from('survey_mitra')
                  ->where('survey_id', $this->id);
        })
        ->select('id', 'name', 'email')
        ->orderBy('name')
        ->get();
    }

    public function getUserUnregistered() {
        return [];
    }
 
    public function mitras()
    {
        return $this->belongsToMany(Mitra::class, 'survey_mitra')
                    ->withPivot('posisi', 'pj_id')
                    ->withTimestamps();
    }
 
    /**
     * Get mitras count by position
     */
    public function getMitrasCountByPosition()
    {
        return $this->mitras()
                    ->select('survey_mitra.posisi', 'count(*) as total')
                    ->groupBy('survey_mitra.posisi')
                    ->pluck('total', 'posisi')
                    ->toArray();
    }
 
    /**
     * Get mitras count by PIC
     */
    public function getMitrasCountByPIC()
    {
        return $this->mitras()
                    ->select('users.name as pj', 'count(*) as total')
                    ->join('users', 'survey_mitra.pj_id', '=', 'users.id')
                    ->groupBy('users.name')
                    ->pluck('total', 'pj')
                    ->toArray();
    }
 }
