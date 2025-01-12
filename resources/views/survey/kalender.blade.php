@extends('layout.app')

@section('content')
<div class="container mx-auto p-4 dark:bg-gray-900 dark:text-gray-200">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Survei</h1>

    <div class="mt-6">
        <div class="flex justify-between mb-4">

            <div class="relative w-1/3">
                <input type="text" id="search" class="block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search..." />
                <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            
            
            <div class="flex space-x-4">
                <select id="tahun" name="tahun" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>

                <select id="filter" name="filter" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="semua">Semua</option>
                    <option value="sedang">Sedang Berlangsung</option>
                    <option value="belum">Belum Dimulai</option>
                    <option value="sudah">Sudah Berakhir</option>
                </select>

                <button onclick="window.location='{{ route('survei') }}'" class="inline-flex items-center px-4 py-2 text-white bg-blue-500 border border-transparent rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-600 dark:hover:bg-blue-700">
                    Tabel View
                </button>

                <button onclick="window.location='{{ route('addsurvei') }}'" class="inline-flex items-center px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                    Tambah Survei
                </button>
            </div>
        </div>
<div class="bg-gray-100 p-4 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">

   <!-- Calendar Grid -->
   <div class="overflow-x-auto">
       <div class="inline-grid grid-cols-[250px_repeat(366,40px)]">

           <!-- Date Headers -->
           <div class="contents">
                <div class="p-1 text-center text-sm border-b border-r border-r-4 bg-white dark:bg-gray-800 dark:border-gray-600">
                    <div class="font-medium">Kegiatan</div>
                </div>
               <!-- Dates -->
               @for ($i = 1; $i <= 366; $i++)
                   @php
                       $date = \Carbon\Carbon::create(2025, 1, 1)->addDays($i - 1);
                       $isWeekend = $date->isWeekend();
                       $isToday = $date->isToday();
                   @endphp
                   <div class="p-1 text-center text-sm border-b {{ $date->format('d') == 1 ? 'border-l border-l-4' : '' }} {{ $isWeekend ? 'bg-red-50 text-red-600' : 'bg-white' }} {{ $isToday ? 'bg-blue-50' : '' }} dark:bg-gray-800 dark:border-gray-600">
                       <div class="font-medium">{{ $date->format('d') == 1 ? $date->format('d M') : $date->format('d') }}</div>
                       <div class="text-xs text-gray-500">{{ $date->format('D') }}</div>
                   </div>
               @endfor
           </div>

           <div class="contents">
            @foreach($surveys as $index => $survey)
           <!-- Nama kegiatan di kolom pertama -->
           <div class="p-1 text-center text-sm border-b border-r border-r-4 bg-white dark:bg-gray-800 dark:border-gray-600 text-nowrap ">
               {{ $survey->name }}
           </div>

           <!-- Cell kosong sebelum startDate -->
           @for ($i = 1; $i < date('z', strtotime($survey->start_date)) + 1; $i++)
               <div class="border-b h-8"></div>
           @endfor

           <!-- Button range kegiatan -->
           <button onclick="window.location='{{ route('surveidetail', ['id' => $index + 1]) }}'" class="m-1 bg-purple-500 hover:bg-purple-600 text-white font-semibold px-4 rounded" 
                   style="grid-column: span {{ date('z', strtotime($survey->end_date)) - date('z', strtotime($survey->start_date)) + 1 }}">
               {{ $survey->name }}
           </button>

           <!-- Cell kosong setelah endDate -->
           @for ($i = date('z', strtotime($survey->end_date)) + 2; $i <= 366; $i++)
               <div class="border-b h-8"></div>
           @endfor
       @endforeach
            </div>
        </div>
   </div>
</div>
        <div class="flex justify-between mt-4 items-center">
            <ul class="inline-flex items-center -space-x-px">
                <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">Awal Tahun</a></li>
                <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">Bulan Sebelumnya</a></li>
                <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">Hari Ini</a></li>
                <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">Bulan Berikutnya</a></li>
                <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">Akhir Tahun</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
