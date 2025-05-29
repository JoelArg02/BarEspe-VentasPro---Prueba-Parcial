<x-app-layout>
   <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Listado de Categorías</h2>

    @if (session('success'))
        <div class="mb-4 text-green-700 font-semibold text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 text-right">
        <button onclick="openCreateModal()"
            class="inline-block px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
            Registrar nueva categoría
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto rounded border border-gray-200 shadow-sm bg-white text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left border-b">#</th>
                    <th class="px-4 py-3 text-left border-b">Nombre</th>
                    <th class="px-4 py-3 text-left border-b">Estado</th>
                    <th class="px-4 py-3 text-left border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 border-b">{{ $category->name }}</td>
                        <td class="px-4 py-3 border-b">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $category->active ? 'bg-green-200 text-green-800' : 'bg-gray-300 text-gray-700' }}">
                                {{ $category->active ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 border-b">
                            <div class="flex flex-wrap gap-2">
                                <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')"
                                    class="px-3 py-1 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100">
                                    Editar
                                </button>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('¿Deseas eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-red-100">
                                        Eliminar
                                    </button>
                                </form>
                                <form action="{{ route('categories.toggle', $category) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="px-3 py-1 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-yellow-100">
                                        {{ $category->active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-4 py-6 text-gray-500">
                            No hay categorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>

   <!-- Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Editar Categoría</h3>
        <form method="POST" id="editCategoryForm">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" id="edit_category_name"
                    class="w-full rounded border-gray-300 bg-white text-gray-900" required>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-green-100 transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de creación -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Registrar Categoría</h3>
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" required
                    class="w-full rounded border-gray-300 bg-white text-gray-900">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeCreateModal()"
                    class="px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-green-100 transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

    <script>
        function openEditModal(id, name) {
            const form = document.getElementById('editCategoryForm');
            const inputName = document.getElementById('edit_category_name');
            inputName.value = name;
            form.action = `/categories/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }
    </script>

</x-app-layout>
