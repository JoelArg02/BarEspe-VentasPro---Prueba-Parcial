<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Lista de Productos</h2>

        @if (session('success'))
            <div class="mb-4 text-green-700 font-semibold text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 text-right">
            @if (\App\Models\Category::count() > 0)
                <button onclick="openCreateModal()"
                    class="inline-block px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                    Registrar nuevo producto
                </button>
            @else
                <div class="text-sm text-red-600 font-semibold text-right">
                    Para registrar productos, primero debes crear una categoría.
                </div>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto rounded border border-gray-200 shadow-sm bg-white text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left border-b">Nombre</th>
                        <th class="px-4 py-3 text-left border-b">Precio</th>
                        <th class="px-4 py-3 text-left border-b">Stock</th>
                        <th class="px-4 py-3 text-left border-b">Categoría</th>
                        <th class="px-4 py-3 text-left border-b">Imagen</th>
                        <th class="px-4 py-3 text-left border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b text-gray-900">{{ $product->name }}</td>
                            <td class="px-4 py-3 border-b text-gray-900">${{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3 border-b text-gray-900">{{ $product->stock }}</td>
                            <td class="px-4 py-3 border-b text-gray-900">{{ $product->category->name ?? 'Sin categoría' }}</td>
                            <td class="px-4 py-3 border-b">
                                @if ($product->image_base64)
                                    <img src="{{ $product->image_base64 }}" alt="Imagen" class="w-20 h-20 object-cover rounded border border-gray-300">
                                @else
                                    <span class="text-gray-500">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border-b space-x-2">
                                <button onclick='openEditModal(@json($product))'
                                    class="inline-block px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                                    Editar</button>

                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar este producto?')"
                                        class="inline-block px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                                        Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-gray-500">
                                No hay productos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 w-full max-w-7xl">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Editar Producto</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="product_id" id="edit_id">
            <input type="hidden" name="image_base64" id="edit_image_base64">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" id="edit_name"
                        class="w-full rounded border-gray-300 bg-white text-gray-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" name="price" step="0.01" id="edit_price"
                        class="w-full rounded border-gray-300 bg-white text-gray-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="edit_stock"
                        class="w-full rounded border-gray-300 bg-white text-gray-900">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" id="edit_image_file" accept="image/*"
                    class="w-full border border-gray-300 rounded bg-white text-gray-900">
                <img id="edit_image_preview" src="" alt="Vista previa"
                    class="mt-2 h-20 w-20 rounded border border-gray-300 object-cover">
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-green-100 transition">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de creación -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 w-full max-w-7xl">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Registrar Producto</h3>
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" class="w-full rounded border-gray-300 bg-white text-gray-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" name="price" step="0.01" class="w-full rounded border-gray-300 bg-white text-gray-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" class="w-full rounded border-gray-300 bg-white text-gray-900" required>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" name="image_file" accept="image/*" class="w-full border border-gray-300 rounded bg-white text-gray-900">
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select name="category_id" class="w-full rounded border-gray-300 bg-white text-gray-900" required>
                    @foreach (\App\Models\Category::where('active', true)->get() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
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
        function openEditModal(product) {
            document.getElementById('edit_id').value = product.id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_stock').value = product.stock;
            document.getElementById('edit_image_base64').value = product.image_base64;
            document.getElementById('edit_image_preview').src = product.image_base64 ?? '';
            document.getElementById('editForm').action = `/products/${product.id}`;
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
        document.getElementById('edit_image_file').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const maxSizeMB = 1;
            const maxSizeBytes = maxSizeMB * 1024 * 1024;

            if (file.size > maxSizeBytes) {
                alert(`La imagen supera el tamaño máximo permitido de ${maxSizeMB} MB.`);
                this.value = '';
                document.getElementById('edit_image_preview').src = '';
                document.getElementById('edit_image_base64').value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit_image_base64').value = e.target.result;
                document.getElementById('edit_image_preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>
