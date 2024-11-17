<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Mitra;

class MitraController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index()
    {
        $mitras = Mitra::withCount(['surveys as jumlah_survei', 'surveys as survei_aktif' => function($query) {
            $query->where('start_date', '<=', now())
                  ->where('end_date', '>=', now());
        }])
        ->orderBy('name')
        ->get();
        return view('mitra.index', [
            'user' => $this->user,
            'mitras' =>  $mitras
        ]); // Mengirim data ke view// Mengirim data ke view
    }

    public function add()
    {
        return view('mitra.add', ['user' => $this->user]); // Mengirim data ke view
    }
    public function edit()
    {
        return view('mitra.edit', ['user' => $this->user]); // Mengirim data ke view
    }

    public function show($id)
    {
        $mitra = $this->mitras[$id - 1] ?? null;

        if (!$mitra) {
            return redirect()->route('mitra')->withErrors('Mitra tidak ditemukan.');
        }

        return view('mitra.detail', [
            'user' => $this->user,
            'mitra' => $mitra
        ]);
    }

}

