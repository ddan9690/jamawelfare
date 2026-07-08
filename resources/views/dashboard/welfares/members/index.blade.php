@extends('layouts.dashboard')

@section('title', 'Members - ' . $welfare->name)

@section('content')
    <div class="max-w-6xl mx-auto p-4 md:p-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <a href="{{ route('welfares.show', [$welfare->id, $welfare->slug]) }}"
                    class="text-stone-500 hover:text-teal-900 font-bold text-sm block mb-2">&larr; Back to Welfare</a>
                <h1 class="text-3xl font-black text-teal-900">{{ $welfare->name }} Member Directory</h1>
            </div>
            <div class="flex items-center gap-3">
                <input type="text" id="memberSearch" placeholder="Search members..."
                    class="bg-white border border-stone-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-500 w-full md:w-64 shadow-sm">

                @if (Gate::allows('manageWelfare', $welfare) || auth()->user()->is_super_admin)
                    <a href="{{ route('welfare.members.pdf', ['id' => $welfare->id, 'slug' => $welfare->slug]) }}"
                        class="bg-teal-900 text-white px-5 py-3 rounded-xl text-sm font-bold hover:bg-amber-600 transition flex items-center gap-2 shadow-sm whitespace-nowrap">
                        <i class='bx bxs-file-pdf'></i> Export PDF
                    </a>
                @endif
            </div>
        </div>

        <!-- Active Members Section -->
        <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-stone-100 bg-stone-50/50">
                <h3 class="font-black text-teal-900 text-lg">Active Members ({{ $activeMembers->count() }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-stone-400 uppercase bg-stone-50">
                        <tr>
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Member #</th>
                            <th class="px-6 py-4">Phone</th>
                            <th class="px-6 py-4">TSC Number</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 member-table">
                        @forelse($activeMembers as $index => $member)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="px-6 py-4 font-bold text-stone-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-bold text-teal-900">{{ $member->user->name }}</td>
                                <td class="px-6 py-4 text-stone-600">{{ $member->member_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-stone-600">{{ $member->user->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-stone-600">{{ $member->user->tsc_number ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-stone-400 font-bold">No active members.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inactive Members Section -->
        <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-stone-100 bg-stone-50/50">
                <h3 class="font-black text-red-900 text-lg">Inactive Members ({{ $inactiveMembers->count() }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <tbody class="divide-y divide-stone-100 member-table">
                        @forelse($inactiveMembers as $index => $member)
                            <tr class="hover:bg-stone-50 transition opacity-75">
                                <td class="px-6 py-4 font-bold text-stone-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-bold text-stone-700">{{ $member->user->name }}</td>
                                <td class="px-6 py-4 text-stone-500">{{ $member->member_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-stone-500">{{ $member->user->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-stone-500">{{ $member->user->tsc_number ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-stone-400 font-bold">No inactive
                                    members.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('memberSearch').addEventListener('keyup', function() {
                let input = this.value.toLowerCase();
                document.querySelectorAll('.member-table tr').forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
                });
            });
        </script>
    @endpush
@endsection
