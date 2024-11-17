@extends('layout.app')

@section('content')
   <div class="container mx-auto p-4">
   <!-- Sticky Navigation Tabs -->
   <div class="sticky top-0 bg-white dark:bg-gray-800 z-50 shadow-md">
       <nav class="flex border-b border-gray-200 dark:border-gray-700" id="tabs">
           <button class="flex-1 py-4 px-6 text-blue-300 text-center tab-btn border-b-2 border-blue-500 font-semibold" data-tab="registered"           >
               Mitra Terdaftar
           </button>
           <button class="flex-1 py-4 px-6 text-white text-center tab-btn" data-tab="unregistered"           >
               Mitra Belum Terdaftar
           </button>
       </nav>
   </div>

   <!-- Desktop Layout (2 columns) -->
   <div class="grid md:grid-cols-12 gap-4 mt-6 text-white">
       <!-- Right Table (Registered) -->
       <div class="col-span-12 md:col-span-6 tab-content" id="registered">
           <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
               <div class="sticky top-12 p-4 border-b dark:border-gray-700">
                   <input type="text" class="search block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search..." />
               </div>
               <div class="p-4 overflow-x-auto">
                   <table class="w-full">
                       <thead>
                           <tr>
                               <th class="px-4 py-2">No</th>
                               <th class="px-4 py-2 hidden md:table-cell">Sobat ID/NIP - Email</th>
                               <th class="px-4 py-2">Nama</th>
                               <th class="px-4 py-2">Posisi - PJ</th>
                           </tr>
                       </thead>
                       <tbody>
                       @if ($mitras->count() == 0)
                        <tr><td colspan="4" class="text-center px-4 py-4">Belum ada data mitra terdaftar.</td></tr>
                        @else
                            @foreach($mitras as $mitra)
                           <tr>
                               <td class="px-4 py-2">{{ $loop->iteration }}</td>
                               <td class="px-4 py-2 hidden md:table-cell">{{ $mitra->id }} -<br>{{ $mitra->email }}</td>
                               <td class="px-4 py-2 text-nowrap">{{ $mitra->name }}</td>
                               <td class="px-4 py-2 text-nowrap">{{ $mitra->posisi }} <br> {{ $mitra->pj }}</td>
                           </tr>
                           @endforeach
                       @endif
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
       <!-- Left Table (Unregistered) -->
       <div class="col-span-12 md:col-span-6 tab-content" id="unregistered">
           <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
               <div class="sticky top-12 p-4 border-b dark:border-gray-700">
                   <input type="text" class="search block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search..." />
               </div>
               <div class="p-4 overflow-x-auto">
                   <table class="w-full">
                       <thead>
                           <tr>
                               <th class="px-4 py-2">Aksi</th>
                               <th class="px-4 py-2 hidden md:table-cell">Sobat ID/NIP - Email</th>
                               <th class="px-4 py-2">Nama</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach($unregMitras as $mitra)
                           <tr>
                               <td class="flex items-center px-4 py-2">
                               <input id="link-checkbox" type="checkbox" value="" class="w-4 mr-2 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                   <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                       Tambah
                                   </button>
                               </td>
                               <td class="px-4 py-2 text-center text-nowrap hidden md:table-cell max-w-[25%] truncate">{{ $mitra->id }} -<br>{{ $mitra->email }}</td>
                               <td class="px-4 py-2 text-nowrap max-w-[25%] truncate">{{ $mitra->name }}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
       </div>

   </div>
    <div class="flex justify-between mt-6">
        <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
            Back
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
   // Tab switching functionality
   const tabs = document.querySelectorAll('.tab-btn');
   const contents = document.querySelectorAll('.tab-content');

   // Only handle tab clicks on mobile
       tabs.forEach(tab => {
           tab.addEventListener('click', () => {
               // Remove active classes from all tabs
               tabs.forEach(t => {
                   t.classList.remove('border-b-2', 'border-blue-500', 'text-blue-300');
                   t.classList.add('text-white');
               });

               // Add active classes to clicked tab
               tab.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
               tab.classList.remove('text-white');

               // Hide all contents
               contents.forEach(content => {
                   content.classList.add('hidden');
               });

               // Show selected content
               document.getElementById(tab.dataset.tab).classList.remove('hidden');
           });
       });
});
</script>
@endsection