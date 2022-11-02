<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Retorna lista de produtos cadastrados
     *
     * @return Collection
     */
    public function index() 
    {
        $products = Product::get();
        
        return new ProductCollection($products);
    }

    /**
     * Adiciona um novo produto
     *
     * @param Request $request
     * @return Product
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ['required', 'string'],
            "price" => ['required', 'numeric'],
            "image" => ['required', 'url'],
        ]);

        $productData =  $request->all();
        return Product::create($productData);
    }

    /**
     * Visualiza um produto especifico
     *
     * @param [type] $id
     * @return Product
     */
    public function show($id) 
    {
        return Product::findOrFail($id);
    }

    /**
     * Atualiza um produto especifico
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return $product;
    }

    /**
     * Remove um produto especifico
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }
}
