@extends('layouts.dashboard')

@section('title', 'Manage Welfares')

@section('content')
<div x-data="{ 
    showDescModal: false, 
    showLogoModal: false, 
    modalContent: '', 
    selectedLogo: '',
    selectedCounty: 'all' 
}" class="p-4 md:p-6">


    @if(session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="mb-6 p-4 rounded-xl border {{ session('success') ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-800' }}">
            <div class="flex justify-between items-center">
                <p class="text-sm font-bold">{{ session('success') ?? session('error') }}</p>
                <button @click="show = false" class="hover:opacity-75"><i class='bx bx-x text-lg'></i></button>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-black text-teal-900">Welfare Associations</h2>
        </div>
        <div class="flex gap-4 w-full md:w-auto">
            <select x-model="selectedCounty" class="flex-1 md:flex-none px-4 py-2 rounded-xl border border-stone-200 text-sm font-bold text-stone-700 outline-none focus:ring-2 focus:ring-teal-500">
                <option value="all">All Counties</option>
                @foreach($counties as $county)
                    <option value="{{ $county->name }}">{{ $county->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('welfares.create') }}" class="bg-teal-900 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-teal-800 transition">Add New</a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white p-4 md:p-6 rounded-3xl border border-stone-200 shadow-sm overflow-x-auto">
        <table id="datatable" class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase text-stone-400 border-b border-stone-100">
                    <th class="py-3">Logo</th>
                    <th class="py-3">Name</th>
                    <th class="py-3">Abbr</th>
                    <th class="py-3 text-center">Desc</th>
                    <th class="py-3">County</th>
                    <th class="py-3 text-center">Status</th>
                    <th class="py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($welfares as $w)
                <tr x-show="selectedCounty === 'all' || selectedCounty === '{{ $w->county->name ?? 'N/A' }}'" class="border-b last:border-0 border-stone-50">
                    <td class="py-3">
                        @if($w->logo)
                            <button @click="showLogoModal = true; selectedLogo = '{{ asset('storage/' . $w->logo) }}'">
                                <img src="{{ asset('storage/' . $w->logo) }}" class="w-10 h-10 rounded-full object-cover shadow-sm border border-stone-100 hover:opacity-80 transition">
                            </button>
                        @else
                            <img src="{{ asset('images/welfare-placeholder.svg') }}" class="w-10 h-10 rounded-full object-cover border border-stone-100">
                        @endif
                    </td>
                    <td class="py-3 font-bold text-teal-900 transition duration-200">
                        <a href="{{ route('welfares.show', [$w->id, $w->slug]) }}" class="hover:text-amber-600">
                            {{ $w->name }}
                        </a>
                    </td>
                    <td class="py-3 text-stone-600">{{ $w->abbreviation }}</td>
                    <td class="py-3 text-center">
                        <button @click="showDescModal = true; modalContent = `{{ addslashes($w->description) }}`" 
                                class="text-teal-600 hover:text-teal-800 transition">
                            <i class='bx bx-show text-xl'></i>
                        </button>
                    </td>
                    <td class="py-3 text-stone-600">{{ $w->county->name ?? 'N/A' }}</td>
                    <td class="py-3 text-center">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $w->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                            {{ $w->status }}
                        </span>
                    </td>
                    <td class="py-3 text-right space-x-2">
                        <a href="{{ route('welfares.edit', [$w->id, $w->slug]) }}" class="text-amber-600 font-bold hover:underline">Edit</a>
                        <button onclick="confirmDelete('{{ route('welfares.destroy', [$w->id, $w->slug]) }}')" class="text-red-600 font-bold hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modals -->
    <div x-show="showDescModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50" @click.self="showDescModal = false">
        <div class="bg-white p-6 rounded-2xl max-w-sm w-full shadow-2xl">
            <h4 class="font-bold text-teal-900 mb-2">Description</h4>
            <div class="max-h-[60vh] overflow-y-auto mb-4 text-stone-600 text-sm leading-relaxed">
                <p x-text="modalContent"></p>
            </div>
            <button @click="showDescModal = false" class="w-full py-2 bg-stone-100 rounded-lg font-bold text-sm text-stone-700 hover:bg-stone-200 transition">Close</button>
        </div>
    </div>

    <div x-show="showLogoModal" x-cloak class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50" @click.self="showLogoModal = false">
        <img :src="selectedLogo" class="max-w-full max-h-[80vh] rounded-xl shadow-2xl border-4 border-white">
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "dom": '<"flex justify-between items-center mb-4"f>t<"flex justify-between mt-4"ip>',
            "language": { "search": "_INPUT_", "searchPlaceholder": "Search welfares..." },
            "columnDefs": [{ "orderable": false, "targets": [0, 3, 6] }] 
        });
    });

    function confirmDelete(url) {
        Swal.fire({
            title: 'Delete Welfare?', text: "This action cannot be undone!", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#0f766e', cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = url; form.method = 'POST';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form); form.submit();
            }
        })
    }
</script>
<style>.dataTables_filter input { border: 1px solid #e7e5e4 !important; border-radius: 8px !important; padding: 5px 12px !important; }</style>
@endpush