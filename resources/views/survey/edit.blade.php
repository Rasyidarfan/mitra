@extends('layout.app')

@section('content')
<div class="container mx-auto p-4 dark:bg-gray-900 dark:text-gray-200">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit Survei [{{ old('name', $survey->name) }}]</h1>

    <form action="{{ route('editsurvei.update', $survey->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-12 gap-4 mb-4">
            <div class="col-span-12 md:col-span-8">
                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Survei</label>
                <input type="text" name="nama" id="nama" value="{{ old('name', $survey->name) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
            </div>

            <div class="col-span-12 md:col-span-4">
                <label for="kode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alias</label>
                <input type="text" name="kode" id="kode" value="{{ old('alias', $survey->alias) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
            </div>
        </div>

        <div class="grid md:grid-cols-12 gap-4 mb-4">
            <div class="col-span-12 md:col-span-7">
                <label for="team_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tim Penyelenggara</label>
                <select name="team_id" id="team_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                    @foreach ($RolePenyelenggara as $role)
                    @if ($role->role !== 'Admin' && $role->role !== 'Kepala' && $role->role !== 'Mitra')
                        <option value="{{ $role->id }}" {{ $survey->team_id == $role->id ? 'selected' : '' }}>{{ $role->role }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-span-12 md:col-span-5">
                <label for="mitra" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Mitra</label>
                <input type="number" name="mitra" id="mitra" value="{{ old('mitra', $survey->mitra) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
            </div>
        </div>

        <div class="grid md:grid-cols-12 gap-4 mb-4">
        <div class="col-span-12 md:col-span-6">
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', $survey->start_date) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>

        <div class="col-span-12 md:col-span-6">
            <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Berakhir</label>
            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" value="{{ old('tanggal_berakhir', $survey->end_date) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>
        </div>



        <div class="flex justify-between mt-6">
            <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
                Back
            </button>

            <button type="submit" class="px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
