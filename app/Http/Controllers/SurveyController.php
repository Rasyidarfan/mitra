<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use App\Models\User;
use App\Models\Role;


class SurveyController extends Controller
{
    protected $user;
    protected $survey;

    public function __construct()
    {
        $this->user = User::findOrFail(Auth::id());
    }

    public function index(Request $request)
    {
        // dd($request);
        $data = [
            'user' => $this->user,
            'surveys' => Survey::getFilteredSurveys($request->search,$request->filter, 10)
        ];
    
        return view('survey.index', $data);
    }

    public function kalender(Request $request)
    {
        // Mengirim data survei ke view
        return view('survey.kalender', [
            'user' => $this->user,
            'surveys' => Survey::getFilteredSurveys($request->search,$request->filter, 10)
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
        $rolePenyelenggara = ( $this->user->hasRole('Admin')) ? Role::all() : $this->user->roles ;

        return view('survey.edit', [
            'user' => $this->user,
            'RolePenyelenggara' => $rolePenyelenggara,
            'survey' => $survey
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $survey = Survey::findOrFail($id);
            $userRoleIds = $this->user->roles->pluck('id')->toArray();
    
            // Validation
            $request->validate([
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|max:255',
                'team_id' => ($this->user->hasRole('Admin')) ? 'required|integer|min:1' : 'required|in:'.implode(',', $userRoleIds),
                'mitra' => 'required|integer|min:1',
                'tanggal_mulai' => 'required|date',
                'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            ]);

    
            // Update
            $survey->update([
                'name' => $request->input('nama'),
                'alias' => $request->input('kode'),
                'team_id' => $request->input('team_id'),
                'mitra' => $request->input('mitra'),
                'start_date' => $request->input('tanggal_mulai'),
                'end_date' => $request->input('tanggal_berakhir'),
            ]);
    
            return redirect()->route('survei')->with('success', 'Survei berhasil diperbarui.');
    
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui survei: ' . $e->getMessage());
        }
    }

    public function mitra($id)
    {
        $survey = Survey::findOrFail($id);
    
        return view('survey.mitra', [
            'pj' => User::all(),
            'user'=> $this->user,
            'survey' => $survey,
            'mitras' => $survey->getMitrasDetail(),
            'unregMitras' => $survey->getMitrasUnregistered(),
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:surveys,name',
            'kode' => 'required|string|max:50',
            'team_id' => 'required|exists:roles,id',
            'mitra' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai'
        ], [
            'nama.required' => 'Nama survei harus diisi',
            'nama.unique' => 'Nama survei sudah ada',
            'kode.required' => 'Alias survei harus diisi',
            'team_id.required' => 'Tim harus dipilih',
            'mitra.required' => 'Jumlah mitra harus diisi',
            'mitra.min' => 'Jumlah mitra minimal 1',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_berakhir.required' => 'Tanggal selesai harus diisi',
            'tanggal_berakhir.after' => 'Tanggal selesai harus setelah tanggal mulai'
        ]);

        try {
            // Create survey
            Survey::create([
                'name' => $validated['nama'],
                'alias' => $validated['kode'],
                'team_id' => $validated['team_id'],
                'mitra' => $validated['mitra'],
                'start_date' => $validated['tanggal_mulai'],
                'end_date' => $validated['tanggal_berakhir']
            ]);

            return redirect()->route('survei')->with('success', 'Survei berhasil ditambahkan');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan survei: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $survey = Survey::findOrFail($id);
            $survey->delete();

            return redirect()->route('survei')->with('success', 'Survei berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus survei: ' . $e->getMessage());
        }
    }

    public function addMitra(Request $request, Survey $survey)
    {
        try {
            $validated = $request->validate([
                'mitra_id' => 'required|exists:mitras,id',
                'posisi' => 'required|in:Pencacah,Pengawas,Pengolah'
            ]);
    
            $survey->mitras()->attach($validated['mitra_id'], [
                'posisi' => $validated['posisi'],
                'pj_id' => $this->user->id
            ]);
    
            return redirect()->back()->with('success', 'Mitra berhasil didaftarkan');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mendaftarkan mitra: ' . $e->getMessage());
        }
    }

    public function addMitraBatch(Request $request, Survey $survey)
    {
        try {
            $validated = $request->validate([
                'mitra_ids' => 'required|array',
                'mitra_ids.*' => 'exists:mitras,id',
                'posisi' => 'required|in:Pencacah,Pengawas,Pengolah'
            ]);
    
            // Attach semua mitra dengan posisi yang sama
            foreach($validated['mitra_ids'] as $mitraId) {
                $survey->mitras()->attach($mitraId, [
                    'posisi' => $validated['posisi'],
                    'pj_id' => $this->user->id
                ]);
            }
    
            return redirect()->back()->with('success', count($validated['mitra_ids']) . ' mitra berhasil didaftarkan');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mendaftarkan mitra: ' . $e->getMessage());
        }
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