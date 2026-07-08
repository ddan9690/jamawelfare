@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <a href="{{ route('dashboard') }}" class="text-xs font-bold text-stone-400 hover:text-teal-900 underline mb-6 block">← Back to Dashboard</a>
    
    <!-- Profile Header -->
    <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm mb-6 flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-black text-teal-900">{{ $member->user->name }}</h1>
            <p class="text-stone-500 font-bold mt-1">Member Number: #{{ $member->member_number }}</p>
        </div>
        <button onclick="changeStatus({{ $member->id }}, '{{ addslashes($member->user->name) }}')" 
                class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition shadow-sm 
                {{ $member->status == 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
            {{ ucfirst($member->status) }}
            <span class="block text-[8px] opacity-70 mt-1 underline">Click to Change Status</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Participation Stats -->
        <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm">
            <h3 class="text-lg font-black text-teal-900 mb-6">Benevolence Participation</h3>
            <div class="p-5 bg-teal-900 rounded-2xl flex items-center justify-between mb-6">
                <div>
                    <p class="text-teal-400 text-[10px] font-bold uppercase">Participation Record</p>
                    <p class="text-white text-3xl font-black">{{ $participatedCases }} <span class="text-teal-500 font-normal text-xl">out of {{ $totalCases }} cases</span></p>
                </div>
            </div>
            
            <!-- Trend Chart -->
            <h3 class="text-sm font-black text-stone-800 mb-4">Participation Trend</h3>
            <canvas id="participationChart" height="150"></canvas>
        </div>

        <!-- Member Information -->
        <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm">
            <h3 class="text-lg font-black text-teal-900 mb-6">Member Information</h3>
            <div class="space-y-4 text-sm">
                <div><p class="text-[10px] text-stone-400 font-bold uppercase">Phone</p><p class="font-bold text-stone-800">{{ $member->user->phone ?? 'N/A' }}</p></div>
                <div><p class="text-[10px] text-stone-400 font-bold uppercase">County</p><p class="font-bold text-stone-800">{{ $member->user->county->name ?? 'Not Assigned' }}</p></div>
                <div><p class="text-[10px] text-stone-400 font-bold uppercase">Joined</p><p class="font-bold text-stone-800">{{ $member->created_at?->format('d M Y') ?? 'N/A' }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Chart Logic
    const ctx = document.getElementById('participationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($trendData->keys()) !!},
            datasets: [{
                label: 'Contributions',
                data: {!! json_encode($trendData->values()) !!},
                borderColor: '#0f766e',
                backgroundColor: 'rgba(15, 118, 110, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Status Change Logic
    function changeStatus(id, name) {
        Swal.fire({
            title: 'Change Status',
            text: `Update status for ${name}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Set to Active',
            denyButtonText: 'Set to Inactive',
            showDenyButton: true
        }).then((result) => {
            let status = result.isConfirmed ? 'active' : (result.isDenied ? 'inactive' : null);
            if(status) {
                fetch(`/welfare/member/${id}/status`, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ status })
                }).then(() => location.reload());
            }
        });
    }
</script>
@endpush