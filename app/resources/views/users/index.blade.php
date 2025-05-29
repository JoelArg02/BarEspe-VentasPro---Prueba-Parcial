<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Listado de Usuarios</h2>

    @if (session('success'))
        <div class="mb-4 p-4 text-green-800 bg-green-200 rounded text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full table-auto rounded border border-gray-200 shadow-sm bg-white text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left border-b">#</th>
                    <th class="px-4 py-3 text-left border-b">Nombre</th>
                    <th class="px-4 py-3 text-left border-b">Correo</th>
                    <th class="px-4 py-3 text-left border-b">Rol</th>
                    @if (auth()->user()->hasRole('admin'))
                        <th class="px-4 py-3 text-left border-b">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-3 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 border-b">{{ $user->name }}</td>
                        <td class="px-4 py-3 border-b">{{ $user->email }}</td>
                        <td class="px-4 py-3 border-b">
                            @foreach ($user->roles as $role)
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        @if (auth()->user()->hasRole('admin'))
                            <td class="px-4 py-3 border-b">
                                <button class="text-blue-600 hover:underline font-medium"
                                    onclick='openEditModal({{ $user->id }}, @json($user->name), @json($user->email), @json($user->roles->pluck('name')) )'>
                                    Editar
                                </button>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->hasRole('admin') ? 5 : 4 }}"
                            class="text-center px-4 py-6 text-gray-500">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>



    @if (auth()->user()->hasRole('admin'))
        <!-- Modal de Edición -->
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl border border-gray-200">
                <h3 class="text-lg font-bold mb-4 text-gray-900">Editar Usuario</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="user_id" id="editUserId">

                    <div class="mb-4">
                        <label for="editName" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" id="editName"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="editEmail" class="block text-sm font-medium text-gray-700">Correo</label>
                        <input type="email" name="email" id="editEmail"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="editRole" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="roles[]" id="editRole"
                            class="w-full px-4 py-2 rounded border border-gray-300">
                            @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="px-4 py-2 bg-white border border-black text-black hover:bg-gray-100 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @endif

    <script>
        function openEditModal(id, name, email, roles) {
            const form = document.getElementById('editForm');
            document.getElementById('editUserId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            form.action = `/user/${id}`;

            // seleccionar solo el primer rol
            if (roles.length > 0) {
                document.getElementById('editRole').value = roles[0];
            }

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
