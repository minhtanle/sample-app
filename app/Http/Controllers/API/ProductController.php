<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ProductCreateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $id = $request->get('id');
            $store_id = $request->get('store_id');
            $name = $request->get('name');
            $pageSize = $request->get('pageSize') ?? 5;

            $product = new Product();
            if (!blank($id)) {
                $product = $product->where('id', $id);
            }
            if (!blank($store_id)) {
                $product = $product->where('store_id', $store_id);
            }
            if (!blank($name)) {
                $product = $product->where('name', $name);
            }
            $product = $product->paginate($pageSize);

            return Response::json($product);
        } catch (\Throwable $th) {
            logger('Error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ':' . $th->getLine());

            return Response::json([
                'success' => false,
                'code' => 201
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        try {
            $product = Product::create($request->all());

            return Response::json([
                'data' => $product->toArray(),
                'success' => true,
                'code' => 201
            ], 201);
        } catch (\Throwable $th) {
            logger('Error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ':' . $th->getLine());

            return Response::json([
                'success' => false,
                'code' => 404
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return Response::json([
                    'success' => false,
                    'code' => 404
                ], 404);
            }

            return Response::json([
                'data' => $product->toArray(),
                'success' => true,
                'code' => 200
            ]);
        } catch (\Throwable $th) {
            logger('Error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ':' . $th->getLine());

            return Response::json([
                'success' => false,
                'code' => 404
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCreateRequest $request, string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return Response::json([
                    'success' => false,
                    'code' => 404
                ], 404);
            }

            $product->fill($request->all());

            return Response::json([
                'data' => $product->toArray(),
                'success' => true,
                'code' => 204
            ]);
        } catch (\Throwable $th) {
            logger('Error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ':' . $th->getLine());

            return Response::json([
                'success' => false,
                'code' => 404
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return Response::json([
                    'message' => 'Product not exists',
                    'success' => false,
                    'code' => 404
                ], 404);
            }

            $product->delete();

            return Response::json([
                'success' => true,
                'code' => 204
            ]);
        } catch (\Throwable $th) {
            logger('Error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ':' . $th->getLine());

            return Response::json([
                'success' => false,
                'code' => 404
            ], 404);
        }
    }
}
