<?php

namespace App\Http\Controllers\Seller;

use App\User;
use App\Seller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProductTransformer;
use App\Http\Requests\Product\ProductRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('transform.input:'.ProductTransformer::class);
        $this->middleware('scope:manage-products')->except('index');
        $this->middleware('can:view,seller')->only('index');
        $this->middleware('can:sale,seller')->only('store');
        $this->middleware('can:edit-product,seller')->only('update');
        $this->middleware('can:delete-product,seller')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        if (request()->user()->tokenCan('read-general') || request()->user()->tokenCan('manage-products')){
            $products=$seller->products()->get()->unique()->values();
            return $this->showAll($products);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request,User $seller)
    {
        $data=$request->all();
        $data['status']     =Product::PRODUCTO_NO_DISPONIBLE;
        $data['image']      =$request->image->store('','images');
        $data['seller_id']  =$seller->id;
        $product=Product::create($data);
        return $this->showOne($product,201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Seller $seller,Product $product)
    {

        $this->verificarVendedor($seller,$product);
        $product->fill($request->only([
            'name',
            'description',
            'quantity'
        ]));


        if ($request->has('status')){
            $product->status=$request->status;

            if($product->estaDisponible() && $product->categories()->count()==0){
                return $this->errorResponse('UN producto Activo debe tener almenos una categoria',
                        409);
            }
        }
        if($request->hasFile('image')){
            Storage::delete($product->image);
            $product->image=$request->image->store('','images');
        }
        if ($product->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor difernete para actualizar'
                        ,422);
        }
        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,Product $product)
    {
        $this->verificarVendedor($seller,$product);
        Storage::delete($product->image);
        $product->delete();
        return $this->showOne($product);
    }

    protected function verificarVendedor(Seller $seller,Product $product){
        if($seller->id != $product->seller_id){
            throw new HttpException(422,"Error processing Request");
        }
    }
}
