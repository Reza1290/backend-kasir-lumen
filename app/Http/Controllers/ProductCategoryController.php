<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $productCategories = ProductCategory::paginate();
        return response()->json(['data' => $productCategories]);
    }
    public function indexall()
    {
        $productCategories = ProductCategory::all();
        return response()->json(['data' => $productCategories]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $productCategory = ProductCategory::create($validatedData);

        return response()->json(['data' => $productCategory], 201);
    }

    public function show($id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        return response()->json(['data' => $productCategory]);
    }

    public function update(Request $request, $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
        ]);

        $productCategory->update($validatedData);

        return response()->json(['data' => $productCategory]);
    }

    public function destroy($id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        $productCategory->delete();

        return response()->json(['message' => 'Product category deleted successfully']);
    }
}
