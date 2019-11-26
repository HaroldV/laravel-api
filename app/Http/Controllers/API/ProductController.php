<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;
use Validator;
use App\Http\Resources\Product as ProductResource;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $product = Product::all();
        return $this->sendResponse(ProductResource::collection($product), 'Product retrieved successfully');
    }

    /**
     * save product of the resource
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation error', $validator->errors());
        }

        $product = Product::create($input);

        return $this->sendResponse(new ProductResource($product), 'Product created successfully');
    }

    /**
     * Display the specified resource
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(is_null($product)){
            return $this->sendError('Product not found');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retreived successfully');
    }

    /**
     * Update specified product
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'=> 'required',
            'detailt' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation error', $validator->errors());
        }

        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product Update successfully');
    }

    /**
     * Delete specified product
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully');
    }

}
