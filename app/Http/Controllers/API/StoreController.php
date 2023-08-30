<?php

namespace App\Http\Controllers\API;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreCreateRequest;
use App\Models\Product;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $id = $request->get('id');
            $user_id = $request->get('user_id');
            $name = $request->get('name');
            $pageSize = $request->get('pageSize') ?? 5;

            $store = new Store();
            if (!blank($id)) {
                $store = $store->where('id', $id);
            }
            if (!blank($user_id)) {
                $store = $store->where('user_id', $user_id);
            }
            if (!blank($name)) {
                $store = $store->where('name', $name);
            }
            $store = $store->paginate($pageSize);

            return Response::json($store);
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
    public function store(StoreCreateRequest $request)
    {
        try {
            $store = Store::create($request->all());

            return Response::json([
                'data' => $store->toArray(),
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
            $store = Store::find($id);

            if (!$store) {
                return Response::json([
                    'success' => false,
                    'code' => 404
                ], 404);
            }

            return Response::json([
                'data' => $store->toArray(),
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
    public function update(StoreCreateRequest $request, string $id)
    {
        try {
            $store = Store::find($id);

            if (!$store) {
                return Response::json([
                    'success' => false,
                    'code' => 404
                ], 404);
            }

            $store->fill($request->all());

            return Response::json([
                'data' => $store->toArray(),
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
            $store = Store::find($id);
            $storeHaveProduct = Product::where('store_id', $id)->exists();

            if ($storeHaveProduct) {
                return Response::json([
                    'message' => 'Store have product, can not delete',
                    'success' => false,
                    'code' => 404
                ], 404);
            }

            if (!$store) {
                return Response::json([
                    'message' => 'Store not exists',
                    'success' => false,
                    'code' => 404
                ], 404);
            }

            $store->delete();

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
