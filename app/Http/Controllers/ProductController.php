<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return ProductCollection
     */
    public function index(Request $request)
    {
        $request->validate([
            'category' => ['sometimes','nullable','string'],
            'price' => ['sometimes','integer'],
            'title' => ['sometimes','string'],
            'sortBy'=>['sometimes','in:title'],
            'desc'=>['boolean|required_if:sortBy']
        ]);

        $sorting = [$request->input('sortBy'), $request->input('desc',true)];

        $products = Product::query()
            ->withSort($sorting)
            ->withCategory($request->input('category_uuid'))
            ->withPrice($request->input('price'))
            ->withTitle($request->input('title'))
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param Request $request
     * @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'category_uuid' => $request->input('category_uuid'),
            'uuid' => \Illuminate\Support\Str::uuid(),
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'metadata' => $request->input('metadata'),
        ]);
        return new ProductResource($product);
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return ProductResource
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill([
            'category_uuid' => $request->input('category_uuid'),
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'metadata' => $request->input('metadata'),
        ])->save();

        return new ProductResource($product);
    }

    /**
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        if(!$product->delete()){
            return \response([
                'message' => 'Unable to delete Product.'
            ],'400');
        }

        return \response([
            'message' => 'Product has been deleted successfully.'
        ]);
    }
}
