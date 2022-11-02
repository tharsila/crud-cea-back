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
        
        $product = Product::create($request->all());

        if ($product) {
            return $product;
        }

        return response()->json([
            'message' => 'Erro ao cadastrar o produto!'
        ], 404);
    }

    /**
     * Visualiza um produto especifico
     *
     * @param [type] $id
     * @return Product
     */
    public function show($id) 
    {
        $product = Product::find($id);

        if($product) {
            return $product;
        }

        return response()->json([
            'message' => 'Erro ao visualizar o produto!'
        ], 404);
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

        if ($product) {
            return $product->update($request->all());
        }

        return response()->json([
            'message' => 'Erro ao atualizar o produto!'
        ], 404);
    }

    /**
     * Remove um produto especifico
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        $product = Product::destroy($id);

        if($product) {
            return response()->json([
                'message' => 'Produto removido com sucesso!'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao remover o produto!'
        ], 404);
    }
}
