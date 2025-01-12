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

    public function getPj()
    {
        return $this->hasMany(SurveyMitra::class, 'survey_id')
            ->join('mitras', 'survey_mitra.mitra_id', '=', 'mitras.id')
            ->join('users', 'survey_mitra.pj_id', '=', 'users.id')
            ->select(['mitras.id','mitras.name','mitras.email','survey_mitra.posisi','users.name as pj'])
            ->orderBy('survey_mitra.posisi')->orderBy('mitras.name')->get();
    }

    public function getMitrasUnregistered()
    {
       return Mitra::leftJoin('survey_mitra', function($join) {
               $join->on('mitras.id', '=', 'survey_mitra.mitra_id')
                   ->whereExists(function($query) {
                       $query->from('surveys')->whereColumn('surveys.id', 'survey_mitra.survey_id')->where(function($q) {
                               $q->whereBetween('start_date', [$this->start_date, $this->end_date])
                                ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                                ->orWhere(function($q2) {
                                    $q2->where('start_date', '<=', $this->start_date)
                                        ->where('end_date', '>=', $this->end_date);
                               });
                           });
                   });
           })
           ->leftJoin('surveys', 'surveys.id', '=', 'survey_mitra.survey_id')
           ->whereNotIn('mitras.id', function($query) {
               $query->select('mitra_id')->from('survey_mitra')->where('survey_id', $this->id);
           })
           ->select(['mitras.id','mitras.name', 'mitras.email','surveys.alias as kegiatan_aktif'])
           ->orderBy('mitras.name')->get();
    }

    public function mitras()
    {
        return $this->belongsToMany(Mitra::class, 'survey_mitra')
                    ->withPivot('posisi', 'pj_id')
                    ->withTimestamps();
    }

    public function getMitrasDetail()
    {
        return $this->hasMany(SurveyMitra::class, 'survey_id')
            ->join('mitras', 'survey_mitra.mitra_id', '=', 'mitras.id')
            ->join('users', 'survey_mitra.pj_id', '=', 'users.id')
            ->select(['mitras.id','mitras.name','mitras.email','survey_mitra.posisi','users.name as pj'])
            ->orderBy('survey_mitra.posisi')
            ->orderBy('mitras.name')
            ->get();
    }
 
    public function getMitrasCountByPosition()
    {
        return $this->mitras()
                    ->select('survey_mitra.posisi', 'count(*) as total')
                    ->groupBy('survey_mitra.posisi')
                    ->pluck('total', 'posisi')
                    ->toArray();
    }
 
    public function getMitrasCountByPIC()
    {
        return $this->mitras()
                    ->select('users.name as pj', 'count(*) as total')
                    ->join('users', 'survey_mitra.pj_id', '=', 'users.id')
                    ->groupBy('users.name')
                    ->pluck('total', 'pj')
                    ->toArray();
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%");
        });
    }

    public function scopeFilterByTime($query, $filter)
    {
        return match($filter) {
            'sedang' => $query->where('start_date', '<=', now())->where('end_date', '>=', now()),
            'belum'  => $query->where('start_date', '>', now()),
            'sudah'  => $query->where('end_date', '<', now()),
            default  => $query
        };
    }

    public function scopeDefaultOrder($query)
    {
        return $query->orderByRaw('ABS(DATEDIFF(NOW(), start_date)) DESC');
    }


    public static function getFilteredSurveys($search = null, $timeFilter = null, $perPage = 3)
    {
        return static::query()
            ->when($search, fn($query) => $query->search($search))
            ->when($timeFilter, fn($query) => $query->filterByTime($timeFilter))
            ->defaultOrder()
            ->paginate($perPage)
            ->appends(request()->query());
    }
 }
