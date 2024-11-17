@extends('layout.app')

@section('content')
<div class="px-4 py-4 bg-white dark:bg-gray-900">
  <div class="px-4 sm:px-0">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Detail Survei</h1>
  </div>
  <div class="mt-6 border-t border-gray-100 dark:border-gray-700">
    <dl class="divide-y divide-gray-100 dark:divide-gray-700">
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Nama Survei</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['name'] }} ({{ $survey['alias'] }})</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tim Penyelenggara</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey->team->role }}</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tanggal</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['start_date'] }} sampai {{ $survey['end_date'] }}</dd>
      </div>
    </dl>
  </div>
  <div class="flex space-x-4 m-2 sm:px-0">
    <h3 class="text-base font-bold leading-8 text-gray-900 dark:text-gray-100">Daftar Mitra</h3>
      <button type="button" onclick="window.location='{{ route('survei.mitra', ['id' =>$survey->id]) }}'" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">
      Tambah Mitra
    </button>
  </div>
  <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
        <thead class="text-xs text-gray-700 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-800">
          <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3 hidden md:table-cell">Sobat ID</th>
            <th scope="col" class="px-6 py-3 hidden md:table-cell">Email</th>
            <th scope="col" class="px-6 py-3">Nama</th>
            <th scope="col" class="px-6 py-3">Posisi</th>
            <th scope="col" class="px-6 py-3">Penanggung Jawab</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
        @if ($mitras->isEmpty())
          <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-600"><td colspan="7" class="px-6 py-4 text-center">Belum ada Mitra Terdaftar</td></tr>
        @else
          @foreach ($mitras as $index => $mitra)
            <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-600">
            {{-- {{ dump($mitra) }} --}}
              <td class="px-6 py-4">{{ $index + 1 }}</td>
              <td class="px-6 py-4 hidden md:table-cell">{{ $mitra->id }}</td>
              <td class="px-6 py-4 hidden md:table-cell">{{ $mitra->email }}</td>
              <td class="px-6 py-4">{{ $mitra->name }}</td>
              <td class="px-6 py-4">{{ $mitra->posisi }}</td>
              <td class="px-6 py-4">{{ $mitra->pj }}</td>
              <td class="px-6 py-4">
              @if ($user->hasAnyRole(['Umum', $survey->team->role]))
                <button onclick="window.location='{{ route('penilaian') }}'" class="ml-2 px-3 py-1 text-nowrap text-white bg-green-600 rounded-full hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800">Nilai</button>
              @endif
              @if ($user->hasAnyRole(['Admin', $survey->team->role]) || $user->name == $mitra->pj)
                <button onclick="window.location='{{ route('penilaian') }}'" class="ml-2 px-3 py-1 text-nowrap text-white bg-red-600 rounded-full hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800">Hapus</button>
                <button onclick="window.location='{{ route('penilaian') }}'" class="ml-2 px-3 py-1 text-nowrap text-white bg-blue-600 rounded-full hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">Ganti Posisi</button>
              @endif
              @if ($user->hasAnyRole(['Admin', $survey->team->role]))
                <button onclick="window.location='{{ route('penilaian') }}'" class="ml-2 px-3 py-1 text-nowrap text-white bg-yellow-600 rounded-full hover:bg-yellow-700 dark:bg-yellow-700 dark:hover:bg-yellow-800">Ganti Pj</button>
              @endif
              </td>
            </tr>
          @endforeach
        @endif
        </tbody>
      </table>
    </div>
  </div>
  <div class="flex justify-between mt-6">
    <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
      Back
    </button>
  </div>
</div>


@endsection
