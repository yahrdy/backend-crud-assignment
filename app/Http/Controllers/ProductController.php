<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = \request('per_page') ?? 20;
        $sort = \request('sort') ?? 'created_at';
        $desc = \request('desc') ? 'desc' : 'asc';
        $query = \request('query');
        $products = Product::orderBy($sort, $desc);
        if ($query) {
            $products->whereRaw('UPPER(title) LIKE ?', ['%' . strtoupper($query) . '%']);
        }
        return $products->paginate($per_page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'price' => 'required|integer'
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        unset($data['image']);
        if ($request->hasFile('image')) {
            $data['image'] = str_replace('public/storage/', '', $request->file('image')->store('public/storage/images'));
        }
        $product = Product::create($data);
        return response($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        unset($data['image']);
        if ($request->hasFile('image')) {
            if ($product->getAttributes()['image']) {
                Storage::delete($product->getAttributes()['image']);
            }
            $data['image'] = str_replace('public/storage/', '', $request->file('image')->store('public/storage/images'));
        }
        $product->update($data);
        return response($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->getAttributes()['image']) {
            Storage::delete($product->getAttributes()['image']);
        }
        $product->delete();
        return response($product);
    }
}
