<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Pagination;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate();
        return response()->json(['data' => $products]);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            'name' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric',
            'id_category' => 'required',
        ]);
        $product = Product::create($request->all());
        $stok = ProductStock::create(['id_product' => $product->id,'units'=> 0]);

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

        $validatedData = Validator::make($request->all(),[
            'name' => 'string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'price' => 'numeric',
            'id_category' => '',
        ]);

        $product->update($request->all());

        return response()->json(['data' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
