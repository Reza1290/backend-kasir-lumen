<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination;
use Illuminate\Contracts\Support\Jsonable;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate();
        return response()->json(['data' => $products]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($validatedData);

        return response()->json(['data' => $product], 201);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['data' => $product]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'price' => 'numeric',
        ]);

        $product->update($validatedData);

        return response()->json(['data' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
