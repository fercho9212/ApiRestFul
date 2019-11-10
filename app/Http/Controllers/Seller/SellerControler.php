<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerControler extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores=Seller::has('products')->get();
        return $this->showAll($vendedores);
    }

    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }

}
