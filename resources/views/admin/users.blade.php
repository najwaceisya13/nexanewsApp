@extends('layouts.admin')

@section('title', 'Kelola User - NexaNews')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Kelola User</h1>

    @if(session('success'))
    <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">Nama</th>
                    <th class="px-6 py-4 text-left font-semibold">Email</th>
                    <th class="px-6 py-4 text-left font-semibold">Role</th>
                    <th class="px-6 py-4 text-left font-semibold">Status</th>
                    <th class="px-6 py-4 text-left font-semibold">Bergabung</th>
                    <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @if($user->id !== auth()->id())
                        <button onclick="openEditUserModal({{ $user->id }}, '{{ $user->role }}', '{{ $user->status }}')" class="text-blue-600 hover:text-blue-800 text-sm">
                            Edit
                        </button>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>
        
        <form id="editUserForm" method="POST" action="">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-900 mb-2">Role</label>
                <select name="role" id="userRole" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Status</label>
                <select name="status" id="userStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeEditUserModal()" class="flex-1 btn-outline">Batal</button>
                <button type="submit" class="flex-1 btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@section('additional_js')
<script>
    function openEditUserModal(userId, role, status) {
        document.getElementById('userRole').value = role;
        document.getElementById('userStatus').value = status;
        document.getElementById('editUserForm').action = `/admin/users/${userId}/role`;
        document.getElementById('editUserModal').classList.remove('hidden');
    }

    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }
</script>
@endsection
@endsection
