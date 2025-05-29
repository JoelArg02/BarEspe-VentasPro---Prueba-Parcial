<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Tus Ventas</h2>

        @if (session('success'))
            <div class="mb-4 text-green-700 font-semibold text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 text-right">
            <button onclick="openCreateModal()"
                class="inline-block px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                Registrar nueva venta
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto rounded border border-gray-200 shadow-sm bg-white text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left border-b">#</th>
                        <th class="px-4 py-3 text-left border-b">Productos</th>
                        <th class="px-4 py-3 text-left border-b">Total</th>
                        <th class="px-4 py-3 text-left border-b">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td class="px-4 py-3 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 border-b">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($sale->products as $product)
                                        <li>
                                            <strong>{{ $product->name }}</strong>
                                            <span>x {{ $product->pivot->quantity }}</span>
                                            <span class="text-gray-500">(${{ number_format($product->pivot->unit_price, 2) }} c/u)</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-3 border-b font-medium">
                                ${{ number_format($sale->total_price, 2) }}
                            </td>
                            <td class="px-4 py-3 border-b">
                                {{ $sale->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-4 py-6 text-gray-500">
                                No hay ventas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    @include('sales.create', ['products' => $products])

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', () => openCreateModal());
        @endif
    </script>
</x-app-layout>
