@extends('layout.app')

@section('content')
<div class="container mx-auto p-4 dark:bg-gray-900 dark:text-gray-200">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Survei</h1>

    <div class="mt-6">
        <form id="filterForm" action="{{ route('survei') }}" method="GET" class="flex justify-between mb-4">
            <div class="relative w-1/3">
                <input type="text" name="search" id="search" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" value="{{ request('search') }}" class="block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search..." />
                <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            
            <div class="flex space-x-4">
                <select id="tahun" name="tahun" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>

                <select id="filter" name="filter" onchange="this.form.submit()" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="semua" {{ request('filter') == 'semua' ? 'selected' : '' }}>Semua</option>
                    <option value="sedang" {{ request('filter') == 'sedang' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="belum" {{ request('filter') == 'belum' ? 'selected' : '' }}>Belum Dimulai</option>
                    <option value="sudah" {{ request('filter') == 'sudah' ? 'selected' : '' }}>Sudah Berakhir</option>
                </select>

                <a href="{{ route('surveikalender') }}" class="btn cursor-pointer inline-flex items-center px-4 py-2 text-white bg-green-500 border border-transparent rounded-lg shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-600 dark:hover:bg-green-700">
                    Kalender View
                </a>

                <a href="{{ route('addsurvei') }}" class="btn cursor-pointer inline-flex items-center px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                    Tambah Survei
                </a>
            </div>
        </form>

        <div class="bg-gray-100 p-4 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
 
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama Survei</th>
                            <th scope="col" class="px-6 py-3">Alias</th>
                            <th scope="col" class="px-6 py-3">Penyelenggara</th>
                            <th scope="col" class="px-6 py-3">Mitra</th>
                            <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                            <th scope="col" class="px-6 py-3">Tanggal Berakhir</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surveys as $index => $survey)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $survey->name }}</td>
                            <td class="px-6 py-4">{{ $survey->alias }}</td>
                            <td class="px-6 py-4">{{ $survey->team->role }}</td>
                            <td class="px-6 py-4">{{ $survey->mitra }}</td>
                            <td class="px-6 py-4">{{ $survey->start_date }}</td>
                            <td class="px-6 py-4">{{ $survey->end_date }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button onclick="window.location='{{ route('survei.mitra', ['id' => $survey->id]) }}'" class="px-3 py-1 text-white bg-orange-600 rounded hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 dark:bg-orange-700 dark:hover:bg-orange-800">Mitra</button>
                                    @if ($user->hasAnyRole(['Admin', $survey->team->role]))
                                    <button onclick="window.location='{{ route('surveidetail', ['id' => $survey->id]) }}'" class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">Lihat</button>
                                    <button onclick="window.location='{{ route('editsurvei', ['id' => $survey->id]) }}'" class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800">Edit</button>
                                    <button onclick="window.location='{{ route('copysurvei', ['id' => $survey->id]) }}'" class="px-3 py-1 text-white bg-yellow-600 rounded hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-yellow-700 dark:hover:bg-yellow-800">Salin</button>
                                    <button onclick="deleteSurvey({{ $survey->id }}, '{{ $survey->name }}')" class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
                                   @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">{{ $surveys->appends(request()->query())->links() }}</div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeout = null;
    const searchInput = document.getElementById('search');
    
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });
});

function deleteSurvey(id, name) {
   Swal.fire({
       title: 'Hapus Survei?',
       text: `Apakah Anda yakin ingin menghapus survei "${name}"?`,
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#dc2626', // red-600
       cancelButtonColor: '#4f46e5', // indigo-600
       confirmButtonText: 'Ya, Hapus!',
       cancelButtonText: 'Batal'
   }).then((result) => {
       if (result.isConfirmed) {
           // Buat form untuk delete
           const form = document.createElement('form');
           form.method = 'POST';
           form.action = `/survei/${id}`;
           
           const csrfInput = document.createElement('input');
           csrfInput.type = 'hidden';
           csrfInput.name = '_token';
           csrfInput.value = '{{ csrf_token() }}';
           
           const methodInput = document.createElement('input');
           methodInput.type = 'hidden';
           methodInput.name = '_method';
           methodInput.value = 'DELETE';
           
           form.appendChild(csrfInput);
           form.appendChild(methodInput);
           document.body.appendChild(form);
           
           form.submit();
       }
   });
}
</script>
@endsection
