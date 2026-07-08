@extends('layouts.dashboard')

@section('title', 'Membership Requests - ' . $welfare->name)

@section('content')
<div class="max-w-6xl mx-auto p-4 md:p-6" x-data="{ showModal: false, targetReqId: null, targetName: '' }">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('welfares.show', [$welfare->id, $welfare->slug]) }}" class="text-stone-500 hover:text-teal-900 font-bold text-sm block mb-2">&larr; Back to Welfare</a>
            <h1 class="text-2xl font-black text-teal-900">Membership Request Audit Log</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-teal-50 text-teal-800 rounded-xl border border-teal-200 font-bold text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-stone-400 uppercase bg-stone-50">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">TSC Number</th>
                        <th class="px-6 py-4">Level</th>
                        <th class="px-6 py-4">County</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($requests as $index => $req)
                    <tr class="hover:bg-stone-50">
                        <td class="px-6 py-4 font-bold text-stone-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-bold text-teal-900">{{ $req->user->name }}</td>
                        <td class="px-6 py-4 text-stone-600">{{ $req->user->tsc_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-stone-600">{{ $req->user->level ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-stone-600">{{ $req->user->county->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg text-xs font-bold 
                                {{ $req->status == 'pending' ? 'bg-amber-100 text-amber-800' : 
                                   ($req->status == 'approved' ? 'bg-teal-100 text-teal-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($req->status == 'pending')
                                <div class="flex justify-end gap-3">
                                    <button type="button" 
                                            @click="showModal = true; targetReqId = '{{ $req->id }}'; targetName = '{{ $req->user->name }}'" 
                                            class="text-teal-600 font-bold hover:underline">Approve</button>
                                    
                                    <button type="button" 
                                            onclick="confirmReject('{{ route('welfares.requests.update', [$welfare->id, $welfare->slug, $req->id]) }}')"
                                            class="text-red-600 font-bold hover:underline">Reject</button>
                                </div>
                            @else
                                <span class="text-stone-400 text-xs font-bold uppercase italic">Finalized</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-12 text-center text-stone-400 font-bold">No requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Approval Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/60 flex items-center justify-center p-4 z-50">
        <form :action="'/welfares/{{ $welfare->id }}/{{ $welfare->slug }}/requests/' + targetReqId" method="POST" class="bg-white p-8 rounded-3xl max-w-sm w-full shadow-2xl">
            @csrf @method('PUT')
            <h3 class="font-black text-teal-900 text-lg mb-2">Approve Application</h3>
            <p class="text-sm text-stone-600 mb-6">
                You need to assign a membership number to this membership request application for 
                <span class="font-bold text-teal-900" x-text="targetName"></span>.
            </p>
            
            <input type="text" name="member_number" placeholder="Enter Membership Number" 
                   class="w-full p-3 border border-stone-200 rounded-xl mb-6 outline-none focus:ring-2 focus:ring-teal-500 font-bold" required>
            
            <div class="flex gap-3">
                <button type="button" @click="showModal = false" class="flex-1 py-3 bg-stone-100 text-stone-700 rounded-xl font-bold hover:bg-stone-200 transition">Cancel</button>
                <button type="submit" name="status" value="approved" class="flex-1 py-3 bg-teal-900 text-white rounded-xl font-bold hover:bg-teal-800 transition">Confirm Approval</button>
            </div>
        </form>
    </div>
</div>

<form id="rejectForm" method="POST" class="hidden">
    @csrf @method('PUT')
    <input type="hidden" name="status" value="rejected">
</form>

@push('scripts')
<script>
function confirmReject(url) {
    Swal.fire({
        title: 'Confirm Rejection',
        text: "Are you sure you want to reject this request? This action will be logged.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#a8a29e',
        confirmButtonText: 'Yes, Reject'
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.getElementById('rejectForm');
            form.action = url;
            form.submit();
        }
    })
}
</script>
@endpush
@endsection