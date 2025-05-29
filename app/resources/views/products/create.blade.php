<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">Registrar Producto</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Hubo errores al guardar:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                <input type="number" name="price" id="price" step="0.01" required
                    value="{{ old('price') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                <input type="number" name="stock" id="stock" required
                    value="{{ old('stock') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                <select name="category_id" id="category_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Seleccione una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="imageFile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen</label>
                <input type="file" id="imageFile" accept="image/*"
                    class="mt-1 block w-full text-gray-900 dark:text-white dark:bg-gray-700 dark:border-gray-600 border-gray-300 rounded-md shadow-sm">
                <input type="hidden" name="image_base64" id="imageBase64" value="{{ old('image_base64') }}">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('productForm').addEventListener('submit', function(event) {
            const fileInput = document.getElementById('imageFile');
            const base64Input = document.getElementById('imageBase64');

            if (fileInput.files.length === 0) return true;

            event.preventDefault();

            const reader = new FileReader();
            reader.onload = function(e) {
                base64Input.value = e.target.result;
                document.getElementById('productForm').submit();
            };
            reader.readAsDataURL(fileInput.files[0]);
        });
    </script>
</x-app-layout>
