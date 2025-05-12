<x-app-layout>
    <main class="min-h-screen bg-dark-900 text-white font-inter px-6 pt-32 pb-12 max-w-6xl mx-auto">

        <!-- Admin Nav -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.waitlist') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold">Waitlist</a>
        </div>

        <div class="bg-[#0e1525] rounded-xl shadow-xl p-8 space-y-6 mt-4">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-1">User Management</h1>
                    <p class="text-gray-400 text-sm">Manage registered users of Appliance AI.</p>
                </div>
                <a href="{{ route('admin.new-user') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold">Add User</a>
            </div>

            @if(session('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 4000)"
                    x-show="show"
                    x-transition
                    class="bg-green-600 text-white px-4 py-3 rounded-lg shadow-md w-full"
                >
                    {{ session('success') }}
                </div>
            @endif


            <!-- User Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#1a2339] text-gray-400 text-sm">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Created</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-t border-gray-800">
                            <td class="px-4 py-3">{{ $user->id }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->isAdmin() ? 'Admin' : 'User' }}</td>
                            <td class="px-4 py-3">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('admin.edit-user', $user) }}" class="text-blue-400 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.destroy-user', $user) }}" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</x-app-layout>
