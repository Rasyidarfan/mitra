<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PegawaiController extends Controller
{
    protected $user;
    protected $employee;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        return view('pegawai', [
            'user' => $this->user,
            'employees' => User::with('roles')->get()
        ]); // Mengirim data ke view// Mengirim data ke view
    }

    public function add()
    {
        return view('addpegawai', ['user' => $this->user]); // Mengirim data ke view
    }

    public function edit()
    {
        return view('editpegawai', ['user' => $this->user]); // Mengirim data ke view
    }

    public function show($id)
    {
        $employee = $this->employees[$id - 1] ?? null;

        return view('pegawaidetail', [
            'user' => $this->user,
            'employee' => $employee
        ]);
    }
}

