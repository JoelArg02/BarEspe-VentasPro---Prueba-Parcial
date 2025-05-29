<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('products')->where('user_id', auth()->id())->get();
        $products = Product::all();

        return view('sales.index', compact('sales', 'products'));
    }


    public function create()
    {
        return view('sales.create', [
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $productosVenta = [];
        $total = 0;

        foreach ($validated['products'] as $item) {
            $product = Product::findOrFail($item['id']);

            if ($product->stock < $item['quantity']) {
                return back()->withErrors([
                    'stock' => "Stock insuficiente para el producto: {$product->name}",
                ])->withInput();
            }

            $subtotal = round((float)$product->price * (int)$item['quantity'], 2);
            $total += $subtotal;

            $productosVenta[$product->id] = [
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
            ];

            $product->decrement('stock', $item['quantity']);
        }


        $venta = Sale::create([
            'user_id' => Auth::id(),
            'total_price' => round($total, 2),
        ]);

        $venta->products()->attach($productosVenta);

        return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');
    }

}
