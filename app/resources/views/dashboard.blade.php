<x-app-layout>
    <div class="py-8 px-6 max-w-7xl mx-auto space-y-8">

        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900">Panel de Control – BarEspe VentasPro</h1>
            <p class="text-gray-600 text-sm">Bienvenido/a al sistema. Accede a los módulos disponibles según tu rol.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

            @role('admin|secre')
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6 hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Gestión de Usuarios</h2>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>
                            <a href="{{ route('user.create') }}" class="text-blue-600 hover:underline">➤ Registrar usuario</a>
                        </li>
                        <li>
                            <a href="{{ route('user.index') }}" class="text-blue-600 hover:underline">➤ Ver listado de usuarios</a>
                        </li>
                    </ul>
                </div>
            @endrole

            @role('admin|bodega')
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6 hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Gestión de Categorías</h2>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>
                            <a href="{{ route('categories.create') }}" class="text-green-600 hover:underline">➤ Registrar categoría</a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}" class="text-green-600 hover:underline">➤ Ver categorías</a>
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-lg shadow border border-gray-200 p-6 hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Gestión de Productos</h2>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>
                            <a href="{{ route('products.create') }}" class="text-yellow-600 hover:underline">➤ Registrar producto</a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}" class="text-yellow-600 hover:underline">➤ Ver productos</a>
                        </li>
                    </ul>
                </div>
            @endrole

            @role('admin|cajera')
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6 hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Registro de Ventas</h2>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>
                            <a href="{{ route('sales.create') }}" class="text-red-600 hover:underline">➤ Registrar venta</a>
                        </li>
                        <li>
                            <a href="{{ route('sales.index') }}" class="text-red-600 hover:underline">➤ Ver mis ventas</a>
                        </li>
                    </ul>
                </div>
            @endrole

        </div>
    </div>
</x-app-layout>
