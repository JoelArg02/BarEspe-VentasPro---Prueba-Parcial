<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-6">Registrar Nueva Categoría</h1>

        @if (session('success'))
            <div class="mb-4 text-green-700 dark:text-green-400 font-semibold text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('categories.store') }}"
              class="bg-white dark:bg-gray-800 p-6 rounded shadow-md border border-gray-200 dark:border-gray-700 max-w-2xl mx-auto">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de la Categoría</label>
                <input type="text" name="name" id="name"
                       class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm"
                       required>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 dark:border-white dark:text-white dark:bg-transparent dark:hover:bg-gray-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
