<?php

namespace App\Http\Controllers\Seller;

use App\User;
use App\Seller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\ProductRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products=$seller->products()->get()->unique()->values();
        return $this->showAll($products);
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
        $data['status'] =Product::PRODUCTO_NO_DISPONIBLE;
        $data['image']  ='1.jpg';
        $data['seller_id']=$seller->id;
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
        $product->delete();
        return $this->showOne($product);
    }

    protected function verificarVendedor(Seller $seller,Product $product){
        if($seller->id != $product->seller_id){
            throw new HttpException(422,"Error processing Request");
        }
    }
}
