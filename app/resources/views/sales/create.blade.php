<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 w-[95%] max-w-3xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Registrar Venta</h3>

        <form method="POST" action="{{ route('sales.store') }}" id="createSaleForm">
            @csrf

            @if ($errors->any())
                <div class="mb-4 p-4 text-sm bg-red-100 text-red-700 border border-red-300 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="productsContainer" class="space-y-4">
                <!-- Las filas se agregarán dinámicamente -->
            </div>

            <button type="button" onclick="addProductRow()" class="inline-block px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                Agregar producto
            </button>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-sm font-medium rounded border border-gray-400 text-gray-800 bg-white hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button type="submit" class="inline-block px-4 py-2 text-sm font-semibold rounded border border-black text-black bg-white hover:bg-gray-100 transition">
                    Guardar Venta
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    let productIndex = 1;

    function updateStockInRow(row) {
        const select = row.querySelector('select');
        const quantityInput = row.querySelector('input[type="number"]');

        if (!select || !quantityInput) return;

        const selectedOption = select.options[select.selectedIndex];
        const stock = parseInt(selectedOption.dataset.stock);

        quantityInput.max = stock;

        if (parseInt(quantityInput.value) > stock) {
            quantityInput.value = stock;
        }

        if (stock === 0) {
            select.classList.add('text-red-500');
            quantityInput.disabled = true;
            quantityInput.value = 0;
        } else {
            select.classList.remove('text-red-500');
            quantityInput.disabled = false;
        }
    }

    function addProductRow() {
        const container = document.getElementById('productsContainer');
        const row = document.createElement('div');
        row.classList.add('mb-4', 'product-row');
        row.innerHTML = `
            <div class="flex items-start gap-4">
                <div class="w-full">
                    <label class="block mb-1 text-gray-700">Producto</label>
                    <select name="products[${productIndex}][id]" class="w-full mb-2 border-gray-300 rounded">
                        @foreach($products as $product)
                            @if ($product->stock > 0)
                                <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">
                                    {{ $product->name }} (Stock: {{ $product->stock }})
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <label class="block mb-1 text-gray-700">Cantidad</label>
                    <input type="number" name="products[${productIndex}][quantity]" min="1" value="1" class="w-full border-gray-300 rounded">
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()" class="mt-8 px-2 py-1 bg-red-500 text-white rounded">✖</button>
            </div>
        `;
        container.appendChild(row);
        updateStockInRow(row);
        productIndex++;
    }

    document.addEventListener('change', function (e) {
        if (e.target.matches('select[name^="products"]')) {
            const row = e.target.closest('.product-row');
            updateStockInRow(row);
        }
    });

    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');

        // 👇 Aquí está la clave: forzar la actualización del primer producto
        const firstRow = document.querySelector('#productsContainer .product-row');
        if (firstRow) {
            updateStockInRow(firstRow);
        }
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    // Si hubo errores previos, volver a abrir el modal
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            openCreateModal();

            // Esperamos 50ms y luego actualizamos el stock del primer select
            setTimeout(() => {
                const firstRow = document.querySelector('#productsContainer .product-row');
                if (firstRow) {
                    updateStockInRow(firstRow);
                }
            }, 50);
        });
    @endif

    // 👇 Esto asegura que al cargar la página (no solo al abrir modal) el primer select ya muestre el stock
    document.addEventListener('DOMContentLoaded', () => {
        const firstRow = document.querySelector('#productsContainer .product-row');
        if (firstRow) {
            updateStockInRow(firstRow);
        }
    });
</script>
