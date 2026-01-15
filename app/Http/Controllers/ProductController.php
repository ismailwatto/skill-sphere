<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('business_id', Auth::user()->business_id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (!Auth::user()->business_id) {
            abort(403, 'You must be associated with a business to access this area.');
        }
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        if (!Auth::user()->business_id) {
            abort(403, 'You must be associated with a business to create products.');
        }

        $data['business_id'] = Auth::user()->business_id;

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorizeBusiness($product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeBusiness($product);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeBusiness($product);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    protected function authorizeBusiness(Product $product)
    {
        if ($product->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }
}
