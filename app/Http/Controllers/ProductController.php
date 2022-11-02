<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        return Product::get();
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
            "image" => ['required', 'string'],
        ]);

        $productData =  $request->all();
        return Product::create($productData);
    }
}
