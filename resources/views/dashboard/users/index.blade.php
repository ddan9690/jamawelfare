@extends('layouts.dashboard')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-black text-teal-900">User Management (Total: {{ $totalUsers }})</h1>
    </div>
    
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm">
        <table class="w-full text-xs">
            <thead class="bg-stone-50 border-b border-stone-200">
                <tr class="text-left text-stone-400 uppercase">
                    <th class="p-3">#</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">TSC No</th>
                    <th class="p-3">County</th>
                    <th class="p-3">Level</th>
                    <th class="p-3 text-center">Super Admin</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($users as $index => $user)
                <tr class="hover:bg-stone-50">
                    <td class="p-3 text-stone-400">{{ $index + 1 }}</td>
                    <td class="p-3 font-bold text-teal-900">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->phone }}</td>
                    <td class="p-3">{{ $user->tsc_number ?? 'N/A' }}</td>
                    <td class="p-3">{{ $user->county->name ?? 'N/A' }}</td>
                    <td class="p-3">{{ $user->level }}</td>
                    <td class="p-3 text-center text-xl">
                        <button onclick="confirmToggleAdmin({{ $user->id }}, '{{ addslashes($user->name) }}', {{ $user->is_super_admin ? 1 : 0 }})">
                            @if($user->is_super_admin)
                                <i class='bx bxs-toggle-right text-emerald-600'></i>
                            @else
                                <i class='bx bx-toggle-left text-stone-300'></i>
                            @endif
                        </button>
                    </td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-teal-600 font-bold hover:underline mr-2">View</a>
                        <button onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')" class="text-red-600 font-bold hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmToggleAdmin(id, name, currentState) {
    const statusText = currentState ? "remove super admin status from" : "make";
    Swal.fire({
        title: 'Confirm Action',
        text: `Are you sure you want to ${statusText} ${name} super admin?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0f766e',
        confirmButtonText: 'Yes, Confirm'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/users/${id}/toggle-admin`, {
                method: 'PATCH',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            }).then(() => {
                Swal.fire('Success!', `${name}'s status has been updated.`, 'success').then(() => window.location.reload());
            });
        }
    });
}

function deleteUser(id, name) {
    Swal.fire({
        title: 'Delete User?',
        text: `Are you sure you want to delete ${name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            }).then(() => window.location.reload());
        }
    });
}
</script>
@endsection