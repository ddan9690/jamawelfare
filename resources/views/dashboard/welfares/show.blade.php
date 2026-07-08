@extends('layouts.dashboard')

@section('title', $welfare->name)

@section('content')
<div class="max-w-5xl mx-auto p-4 md:p-6" x-data="{ expanded: false, showModal: false }">
    
    <!-- Back Button -->
    <a href="{{ route('welfares.index') }}" class="inline-block mb-6 text-stone-500 hover:text-teal-900 transition font-bold text-sm">
        &larr; Back to Associations
    </a>

    <!-- Global Alerts -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-teal-50 text-teal-800 rounded-xl border border-teal-200 font-bold text-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-xl border border-red-200 font-bold text-sm">{{ $errors->first() }}</div>
    @endif

    <!-- Hero Card -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden mb-8">
        <div class="h-24 bg-stone-50 border-b border-stone-100 relative"></div>
        <div class="pt-2 pb-8 px-8">
            <div class="flex items-end gap-6">
                @if($welfare->logo)
                    <img src="{{ asset('storage/' . $welfare->logo) }}" class="w-24 h-24 rounded-2xl border-4 border-white shadow-md bg-white object-cover -mt-12">
                @endif
                <div class="mt-4">
                    <h1 class="text-3xl font-black text-teal-900">{{ $welfare->name }}</h1>
                    <p class="text-stone-500 font-bold uppercase tracking-widest text-xs mt-1">{{ $welfare->abbreviation }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8">
                <!-- Total Members -->
                <div class="bg-stone-50 p-4 rounded-2xl flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-bold text-stone-400 uppercase">Total Members</p>
                        <p class="text-2xl font-black text-teal-900">{{ $welfare->members->count() }}</p>
                    </div>
                    <a href="{{ route('welfares.members.index', [$welfare->id, $welfare->slug]) }}" class="text-teal-700 font-bold text-xs hover:underline mt-2">View Members &rarr;</a>
                </div>

                <!-- Pending Requests -->
                <div class="bg-stone-50 p-4 rounded-2xl flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-bold text-stone-400 uppercase">Pending Requests</p>
                        <p class="text-2xl font-black text-teal-900">{{ $welfare->membershipRequests->where('status', 'pending')->count() }}</p>
                    </div>
                    <a href="{{ route('welfares.requests.index', [$welfare->id, $welfare->slug]) }}" class="text-teal-700 font-bold text-xs hover:underline mt-2">View Requests &rarr;</a>
                </div>

                <!-- Total Admins -->
                <div class="bg-stone-50 p-4 rounded-2xl">
                    <p class="text-xs font-bold text-stone-400 uppercase">Admins</p>
                    <p class="text-2xl font-black text-teal-900">{{ $welfare->members->where('role', 'admin')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Admins Management -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-black text-teal-900 text-lg">Welfare Admins</h3>
            <button @click="showModal = true" class="bg-teal-900 text-white px-4 py-2 rounded-xl font-bold text-xs hover:bg-teal-800 transition">Add New Admin</button>
        </div>
        
        <table class="w-full text-sm">
            @php $admins = $welfare->members->where('role', 'admin'); @endphp
            @forelse($admins as $admin)
                <tr class="border-b last:border-0 border-stone-50">
                    <td class="py-4 font-bold text-stone-700">{{ $admin->user->name }}</td>
                    <td class="py-4 text-right">
                        <button onclick="confirmRemove('{{ $admin->user->name }}', '{{ route('welfares.removeAdmin', [$welfare->id, $welfare->slug, $admin->id]) }}')" 
                                class="text-red-600 font-bold text-xs hover:underline">Remove</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="py-8 text-center text-stone-400 font-bold">No admin assigned.</td></tr>
            @endforelse
        </table>
    </div>

    <!-- Description Card -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm p-8">
        <h3 class="font-black text-teal-900 text-lg mb-4">About Association</h3>
        <div class="text-stone-600 leading-relaxed text-sm">
            <div x-show="!expanded">
                {{ \Illuminate\Support\Str::words($welfare->description, 100) }}
                @if(\Illuminate\Support\Str::wordCount($welfare->description) > 100)
                    <button @click="expanded = true" class="text-teal-900 font-bold hover:underline ml-1">... Read More</button>
                @endif
            </div>
            <div x-show="expanded" x-cloak>
                {{ $welfare->description }}
                <button @click="expanded = false" class="text-teal-900 font-bold hover:underline ml-1">Show Less</button>
            </div>
        </div>
    </div>

    <!-- Add Admin Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white p-6 rounded-2xl max-w-lg w-full shadow-2xl" @click.away="showModal = false">
            <h4 class="font-bold text-teal-900 mb-4">Search Members to Add</h4>
            <input type="text" id="memberSearch" placeholder="Name, TSC, or Member #" class="w-full p-3 border border-stone-200 rounded-xl mb-4 text-sm outline-none focus:ring-2 focus:ring-teal-500">
            <div class="max-h-60 overflow-y-auto" id="resultsContainer">
                <p class="text-stone-400 text-sm text-center py-4">Start typing to search members...</p>
            </div>
            <button @click="showModal = false" class="mt-6 w-full py-2 bg-stone-100 rounded-lg text-sm font-bold text-stone-700 hover:bg-stone-200">Close</button>
        </div>
    </div>
</div>

<form id="removeForm" method="POST" class="hidden">@csrf</form>
@endsection

@push('scripts')
<script>
function confirmRemove(name, url) {
    Swal.fire({
        title: 'Confirm Removal',
        text: "This will remove " + name + " as a welfare admin.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#115e59',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Remove'
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.getElementById('removeForm');
            form.action = url;
            form.submit();
        }
    })
}

$(document).ready(function() {
    $('#memberSearch').on('keyup', function() {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "{{ route('welfares.searchMembers', [$welfare->id, $welfare->slug]) }}",
                data: { q: query },
                success: function(data) {
                    $('#resultsContainer').empty();
                    if (data.length > 0) {
                        data.forEach(member => {
                            $('#resultsContainer').append(`
                                <div class="grid grid-cols-2 py-3 border-b items-center text-sm">
                                    <div>
                                        <p class="font-bold text-teal-900">${member.user.name}</p>
                                        <p class="text-xs text-stone-500">TSC: ${member.user.tsc_number || 'N/A'}</p>
                                        <p class="text-xs text-stone-500">No: #${member.member_number || 'N/A'}</p>
                                    </div>
                                    <form action="{{ route('welfares.addAdmin', [$welfare->id, $welfare->slug]) }}" method="POST" class="text-right">
                                        @csrf
                                        <input type="hidden" name="member_id" value="${member.id}">
                                        <button type="submit" class="bg-teal-600 text-white px-3 py-1 rounded-lg font-bold text-xs hover:bg-teal-700">Add Admin</button>
                                    </form>
                                </div>
                            `);
                        });
                    } else {
                        $('#resultsContainer').html('<p class="text-stone-400 text-sm text-center py-4">No members found.</p>');
                    }
                }
            });
        }
    });
});
</script>
@endpush