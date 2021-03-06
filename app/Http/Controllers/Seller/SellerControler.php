<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerControler extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
        $this->middleware('can:view,seller')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowedAdminAction();
        $vendedores=Seller::has('products')->get();
        return $this->showAll($vendedores);
    }

    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }

}
