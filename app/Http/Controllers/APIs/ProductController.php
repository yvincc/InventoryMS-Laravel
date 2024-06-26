<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get products by category ID.
     */
    public function getByCategory($category_id)
    {
        $products = Product::where('category_id', $category_id)->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this category'], 404);
        }

        return response()->json($products, 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not typically used in APIs
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:5',
            'stock' => 'required|string|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }


    public function edit($id)
    {
        // Not typically used in APIs
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|string|max:5',
            'stock' => 'sometimes|required|string|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
