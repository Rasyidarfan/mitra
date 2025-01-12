@extends('layout.app')

@section('content')
   <div class="container mx-auto p-4">
   <!-- Sticky Navigation Tabs -->
   <div class="sticky top-12 bg-white dark:bg-gray-800 z-50 shadow-md text-center">
        <h1 class="text-3xl font-bold p-2 text-gray-900 dark:text-gray-100 cursor-pointer hover:text-blue-300 hover:underline" onclick="window.location='{{ route('surveidetail', ['id' => $survey->id]) }}'">Mitra [{{ old('name', $survey->name) }}]</h1>
       <nav class="flex border-b border-gray-200 dark:border-gray-700" id="tabs">
           <button class="flex-1 py-4 px-6 text-blue-300 text-center tab-btn border-b-2 border-blue-500 font-semibold" data-tab="registered">Mitra Terdaftar</button>
           <button class="flex-1 py-4 px-6 text-white text-center tab-btn" data-tab="unregistered">Mitra Belum Terdaftar</button>
       </nav>
        <div class="sticky top-12 p-4 border-b dark:border-gray-700">
            <div class="flex items-center gap-4">
                <button type="button" onclick="window.history.back()" class="flex-shrink-0 w-24 px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
                    Back
                </button>
                <button type="button" id="registered-btn" class="tab-content flex-shrink-0 w-24 px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ubah
                </button>
                <button type="button" id="unregistered-btn" class="tab-content hidden flex-shrink-0 w-24 px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Daftar
                </button>
                <input type="text" id="search" class="flex-grow p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search..." />
            </div>
        </div>
   </div>

   <div class="grid md:grid-cols-12 gap-4 mt-6 text-white">
       <!-- Right Table (Registered) -->
       <div class="col-span-12 tab-content" id="registered">
           <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
               <div class="p-4 overflow-x-auto">
                   <table class="w-full">
                       <thead>
                           <tr>
                               <th class="px-4 py-2">Ubah/Hapus</th>
                               <th class="px-4 py-2 hidden md:table-cell">Sobat ID/NIP</th>
                               <th class="px-4 py-2 hidden md:table-cell">Email</th>
                               <th class="px-4 py-2">Nama</th>
                               <th class="px-4 py-2">Posisi</th>
                               <th class="px-4 py-2">PJ</th>
                           </tr>
                       </thead>
                       <tbody>
                       @if ($mitras->count() == 0)
                        <tr><td colspan="7" class="text-center px-4 py-4">Belum ada data mitra terdaftar.</td></tr>
                        @else
                            @foreach($mitras as $mitra)
                           <tr>
                               <td class="px-4 py-2">
                               @if ($user->hasAnyRole(['Admin', $survey->team->role]) || $user->nama == $mitra->pj)
                                <input type="checkbox" value="{{ $mitra->id }}" name="registred-checkbox" class="w-4 mr-2 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <button type="button" class="flex-shrink-0 w-24 px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600">Ubah</button>
                                @endif
                               </td>
                               <td class="px-4 py-2 sobat_id hidden md:table-cell">{{ $mitra->id }}</td>
                               <td class="px-4 py-2 email hidden md:table-cell">{{ $mitra->email }}</td>
                               <td class="px-4 py-2 nama text-nowrap">{{ $mitra->name }}</td>
                               <td class="px-4 py-2 posisi text-nowrap">{{ $mitra->posisi }}</td>
                               <td class="px-4 py-2 pj text-nowrap">{{ $mitra->pj }}</td>
                           </tr>
                           @endforeach
                       @endif
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
       <!-- Left Table (Unregistered) -->
       <div class="col-span-12 tab-content hidden" id="unregistered">
           <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
               <div class="p-4 overflow-x-auto">
                   <table class="w-full">
                       <thead>
                           <tr>
                               <th class="px-4 py-2">Daftarkan</th>
                               <th class="px-4 py-2 hidden md:table-cell">Sobat ID/NIP</th>
                               <th class="px-4 py-2 hidden md:table-cell">Email</th>
                               <th class="px-4 py-2">Nama</th>
                               <th class="px-4 py-2">Kegiatan</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach($unregMitras as $mitra)
                           <tr>
                               <td class="flex items-center px-4 py-2">
                                    <input type="checkbox" name="unregistred-checkbox" value="{{ $mitra->id }}" class="w-4 mr-2 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <button onclick="showPosisiModal('{{ $mitra->id }}', '{{ $mitra->name }}')" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Daftarkan</button>
                               </td>
                               <td class="px-4 py-2 text-nowrap sobat_id hidden md:table-cell">{{ $mitra->id }}</td>
                               <td class="px-4 py-2 text-nowrap email hidden md:table-cell">{{ $mitra->email }}</td>
                               <td class="px-4 py-2 text-nowrap nama">{{ $mitra->name }}</td>
                                <td>
                                @if($mitra->kegiatan_aktif)
                                    {{ $mitra->kegiatan_aktif }}
                                @else
                                    -
                                @endif
                            </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
       </div>

   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
   // Tab switching functionality
   const tabs = document.querySelectorAll('.tab-btn');
   const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active classes from all tabs
            tabs.forEach(t => {
                t.classList.remove('border-b-2', 'border-blue-500', 'text-blue-300');
                t.classList.add('text-white');
            });

            // Add active classes to clicked tab
            tab.classList.add('border-b-2', 'border-blue-500', 'text-blue-300');
            tab.classList.remove('text-white');

            // Hide all contents
            contents.forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected content
            document.getElementById(tab.dataset.tab).classList.remove('hidden');
            document.getElementById(tab.dataset.tab+'-btn').classList.remove('hidden');
        });
    });

});

function showPosisiModal(mitraId, mitraName) {
    Swal.fire({
        title: `Pilih Posisi untuk <br> ${mitraName}`,
        input: 'select',
        inputOptions: {
            'Pencacah': 'Pencacah',
            'Pengawas': 'Pengawas',
            'Pengolah': 'Pengolah'
        },
        inputPlaceholder: 'Pilih Posisi',
        showCancelButton: true,
        confirmButtonText: 'Daftarkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d68566',
        inputValidator: (value) => {
            if (!value) {
                return 'Anda harus memilih posisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Buat form untuk submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/survei/{{ $survey->id }}/mitra';

            // CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            
            // Method PUT
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';

            // Mitra ID
            const mitraInput = document.createElement('input');
            mitraInput.type = 'hidden';
            mitraInput.name = 'mitra_id';
            mitraInput.value = mitraId;

            // Posisi yang dipilih
            const posisiInput = document.createElement('input');
            posisiInput.type = 'hidden';
            posisiInput.name = 'posisi';
            posisiInput.value = result.value;

            // Append semua input ke form
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            form.appendChild(mitraInput);
            form.appendChild(posisiInput);
            
            // Append form ke body dan submit
            document.body.appendChild(form);
            form.submit();
        }
    });
}

document.getElementById('unregistered-btn').addEventListener('click', function() {
   const selectedMitras = Array.from(document.getElementsByName('unregistred-checkbox')).filter(cb => cb.checked).map(cb => cb.value);

   if(selectedMitras.length === 0) {
       Swal.fire({icon: 'warning',title: 'Peringatan',text: 'Pilih mitra terlebih dahulu!'});
       return;
   }

   Swal.fire({
       title: `Pilih Posisi untuk ${selectedMitras.length} Mitra`,
       input: 'select',
       inputOptions: {
           'Pencacah': 'Pencacah',
           'Pengawas': 'Pengawas',
           'Pengolah': 'Pengolah'
       },
       inputPlaceholder: 'Pilih Posisi',
       showCancelButton: true,
       confirmButtonText: 'Daftarkan',
       cancelButtonText: 'Batal',
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#f68566',
       inputValidator: (value) => {
           if (!value) {
               return 'Anda harus memilih posisi!'
           }
       }
   }).then((result) => {
       if (result.isConfirmed) {
           // Buat form untuk submit
           const form = document.createElement('form');
           form.method = 'POST';
           form.action = '/survei/{{ $survey->id }}/mitra/batch';

           // CSRF token
           const csrfInput = document.createElement('input');
           csrfInput.type = 'hidden';
           csrfInput.name = '_token';
           csrfInput.value = '{{ csrf_token() }}';
           
           // Method PUT
           const methodInput = document.createElement('input');
           methodInput.type = 'hidden';
           methodInput.name = '_method';
           methodInput.value = 'PUT';

           // Mitra IDs
           selectedMitras.forEach(mitraId => {
               const mitraInput = document.createElement('input');
               mitraInput.type = 'hidden';
               mitraInput.name = 'mitra_ids[]';
               mitraInput.value = mitraId;
           });

           // Posisi yang dipilih
           const posisiInput = document.createElement('input');
           posisiInput.type = 'hidden';
           posisiInput.name = 'posisi';
           posisiInput.value = result.value;

           // Append semua input ke form
           form.appendChild(csrfInput);
           form.appendChild(methodInput);
           selectedMitras.forEach(mitraId => {
               const mitraInput = document.createElement('input');
               mitraInput.type = 'hidden';
               mitraInput.name = 'mitra_ids[]';
               mitraInput.value = mitraId;
               form.appendChild(mitraInput);
           });
           form.appendChild(posisiInput);
           
           // Append form ke body dan submit
           document.body.appendChild(form);
           form.submit();
       }
   });
});

function highlightText(text, searchTerm) {
   if (!searchTerm) return text;
   const regex = new RegExp(`(${searchTerm})`, 'gi');
   return text.replace(regex, '<mark class="bg-yellow-200">$1</mark>');
}

// Fungsi search sederhana
const searchInput = document.getElementById('search');

// Debounce helper
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
      const later = () => {
          clearTimeout(timeout);
          func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
  };
}

// Search dengan debounce
const searchWithDebounce = debounce(function(searchTerm) {
  const rows = document.querySelectorAll('tbody tr');
  
  rows.forEach(row => {
      const id = row.querySelector('td.sobat_id')?.textContent.toLowerCase() || '';
      const email = row.querySelector('td.email')?.textContent.toLowerCase() || '';
      const name = row.querySelector('td.nama')?.textContent.toLowerCase() || '';
      const posisi = row.querySelector('.posisi')?.textContent.toLowerCase() || '';
      const pj = row.querySelector('.pj')?.textContent.toLowerCase() || '';
      
      const matches = id + email + name + posisi + pj;
      row.style.display = 'none';
      if(matches.includes(searchTerm)){
        row.style.display = '';
        row.querySelector('td.sobat_id').innerHTML = highlightText(row.querySelector('td.sobat_id').textContent,searchTerm);
        row.querySelector('td.email').innerHTML = highlightText(row.querySelector('td.email').textContent,searchTerm);
        row.querySelector('td.nama').innerHTML = highlightText(row.querySelector('td.nama').textContent,searchTerm);
      }
  });
}, 300);

searchInput.addEventListener('input', function() {
  searchWithDebounce(this.value.toLowerCase());
});


function moveToTop(row, animate = true) {
    const tbody = row.parentNode;
    const rect = row.getBoundingClientRect();
    tbody.insertBefore(row, tbody.firstChild);
    const newRect = row.getBoundingClientRect();
    const deltaY = rect.top - newRect.top;
    
    // Animate
    row.style.transform = `translateY(${deltaY}px)`;
    row.style.transition = 'none';
    
    requestAnimationFrame(() => {
        row.style.transition = 'transform 0.3s ease';
        row.style.transform = 'translateY(0)';
    });
}

function moveToBottom(row) {
   const tbody = row.parentNode;
   const uncheckedRow = Array.from(tbody.querySelector('input[type="checkbox"]:checked')).length;
   
    // Simpan posisi awal
    const currentIndex = Array.from(tbody.children).indexOf(row);
    const lastIndex = tbody.children.length > 5 ? 5 : tbody.children.length - 1;
    const distance = lastIndex - currentIndex;
    
    // Animate down
    row.style.transition = 'transform 0.3s ease';
    row.style.transform = `translateY(${distance * row.offsetHeight}px)`;
    
    // Setelah animasi selesai, pindahkan row
    setTimeout(() => {
        row.style.transition = 'none';
        row.style.transform = '';
        tbody.insertBefore(row, tbody.querySelector('tr:nth-child('+ uncheckedRow +')'));
    }, 300);
}

document.addEventListener('change', function(e) {
    if (e.target.type === 'checkbox') {
        const row = e.target.closest('tr');
        if (e.target.checked) {
            moveToTop(row, true);
        } else {
            moveToBottom(row);
        }
    }
});

function showUbahModal(mitraId, mitraName) {
   // Data untuk dropdown posisi
   const posisiOptions = {
       'Pencacah': 'Pencacah',
       'Pengawas': 'Pengawas',
       'Pengolah': 'Pengolah'
   };

   // Render HTML untuk dropdown PJ
   const pjOptionsHtml = `
       @foreach($pj as $user)
           <option value="{{ $user->id }}">{{ $user->name }}</option>
       @endforeach
   `;
   
   Swal.fire({
       title: `Ubah Posisi dan PJ untuk ${mitraName}`,
       html: `
           <div class="mb-3">
               <label class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
               <select id="posisi" class="w-full p-2 border rounded">
                   ${Object.entries(posisiOptions).map(([value, label]) => 
                       `<option value="${value}">${label}</option>`
                   ).join('')}
               </select>
           </div>
           <div class="{{ ($user->hasAnyRole(['Admin', $survey->team->role])) ? '' : 'hidden' }}">
               <label class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab</label>
               <select id="pj_id" class="w-full p-2 border rounded">
                   ${pjOptionsHtml}
               </select>
           </div>
       `,
       showCancelButton: true,
       confirmButtonText: 'Simpan',
       cancelButtonText: 'Batal',
       confirmButtonColor: '#3085d6',
       customClass: {
           container: 'my-swal'
       }
   }).then((result) => {
       if (result.isConfirmed) {
           const posisi = document.getElementById('posisi').value;
           const pj_id = document.getElementById('pj_id').value;

           // Buat form untuk submit
           const form = document.createElement('form');
           form.method = 'POST';
           form.action = `/survei/{{ $survey->id }}/mitra/${mitraId}`;

           const csrfInput = document.createElement('input');
           csrfInput.type = 'hidden';
           csrfInput.name = '_token';
           csrfInput.value = '{{ csrf_token() }}';

           const methodInput = document.createElement('input');
           methodInput.type = 'hidden';
           methodInput.name = '_method';
           methodInput.value = 'PUT';

           const posisiInput = document.createElement('input');
           posisiInput.type = 'hidden';
           posisiInput.name = 'posisi';
           posisiInput.value = posisi;

           const pjInput = document.createElement('input');
           pjInput.type = 'hidden';
           pjInput.name = 'pj_id';
           pjInput.value = pj_id;

           form.appendChild(csrfInput);
           form.appendChild(methodInput);
           form.appendChild(posisiInput);
           form.appendChild(pjInput);
           document.body.appendChild(form);
           form.submit();
       }
   });
}
</script>
@endsection