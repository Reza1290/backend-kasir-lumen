<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductStock;

class ProductStockController extends Controller
{
    public function index()
    {
        $productStocks = ProductStock::with('product')->paginate();
        return response()->json(['data' => $productStocks]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_product' => 'required|exists:products,id',
            'units' => 'required|integer',
        ]);

        $productStock = ProductStock::create($validatedData);

        return response()->json(['data' => $productStock], 201);
    }

    public function show($id)
    {
        $productStock = ProductStock::findOrFail($id);
        return response()->json(['data' => $productStock]);
    }

    public function update(Request $request, $id)
    {
        $productStock = ProductStock::findOrFail($id);

        $validatedData = $request->validate([
            'id_product' => 'exists:products,id',
            'units' => 'integer',
        ]);

        $productStock->update($validatedData);

        return response()->json(['data' => $productStock]);
    }

    public function destroy($id)
    {
        $productStock = ProductStock::findOrFail($id);
        $productStock->delete();

        return response()->json(['message' => 'Product stock deleted successfully']);
    }
}