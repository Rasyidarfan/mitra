<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;


class SurveyController extends Controller
{
    protected $user;
    protected $survey;

    public function __construct()
    {
        $this->user = User::findOrFail(Auth::id());
    }

    public function index()
    {
        // Mengambil semua data survei dari tabel
        $surveys = Survey::orderByRaw('ABS(DATEDIFF(NOW(), start_date)) DESC')->get();
        $data = [
            'user' => $this->user,
            'surveys' => $surveys
        ];

        return view('survey.index', $data);
    }

    public function kalender()
    {
        // Mengambil semua data survei dari tabel
        $surveys = Survey::orderByRaw('ABS(DATEDIFF(NOW(), start_date)) DESC')->get();

        // Mengirim data survei ke view
        return view('survey.kalender', [
            'user' => $this->user,
            'surveys' => $surveys
        ]);
    }

    public function add($id = null)
    {
        $data = [
            'user' => $this->user,
            'rolePenyelenggara' => ($this->user->hasRole('Admin')) ? Role::all() : $this->user->roles,
            'survey' => ($id) ? Survey::findOrFail($id) : null
        ];
        return view('survey.add', $data);
    }


    public function show($id)
    {
        $survey = Survey::findOrFail($id);
        return view('survey.detail', [
            'user' => $this->user,
            'survey' => $survey,
            'mitras' => $survey->getMitrasDetail()
        ]);
    }

    public function edit($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->tanggal_mulai = Carbon::parse($survey->tanggal_mulai);
        $survey->tanggal_berakhir = Carbon::parse($survey->tanggal_berakhir);
        $rolePenyelenggara = ( $this->user->hasRole('Admin')) ? Role::all() : $this->user->roles ;

        return view('survey.edit', [
            'user' => $this->user,
            'RolePenyelenggara' => $rolePenyelenggara,
            'survey' => $survey
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'ketua_tim' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
        ]);

        $survey = Survey::findOrFail($id);

        // Memperbarui data survei
        $survey->update([
            'name' => $request->input('name'),
            'kode' => $request->input('kode'),
            'ketua_tim' => $request->input('ketua_tim'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_berakhir' => $request->input('tanggal_berakhir'),
        ]);

        return redirect()->route('survei')->with('success', 'Survei berhasil diperbarui.');
    }

    public function mitra($id)
    {
        $survey = Survey::findOrFail($id);
    
        return view('survey.mitra', [
            'user'=> $this->user,
            'survey' => $survey,
            'mitras' => $survey->getMitrasDetail(),
            'unregMitras' => $survey->getMitrasUnregistered(),
        ]);
    }

    public function addMitra(Survey $survey, Request $request)
    {
        $validated = $request->validate([
            'mitra_id' => 'required|exists:mitras,id',
            'posisi' => 'required|in:Pencacah,Pengawas,Pengolah',
        ]);

        $survey->mitras()->attach($request->mitra_id, [
            'user_id' => $this->user->id,
            'posisi' => $request->posisi
        ]);

        return redirect()->back()->with('success', 'Mitra berhasil ditambahkan');
    }

    // Get mitra per survey dengan PJ
    public function getMitras(Survey $survey)
    {
        $mitras = $survey->mitras()
                        ->with('pivot.user')  // eager load PJ
                        ->get();

        return view('survey.mitras', compact('survey', 'mitras'));
    }
}
