<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $this->allowedAdminAction();
        //$seller=$buyer->transations->product->seller;
        $sellers=$buyer->transactions()
                       ->with('product.seller') //Get relations between product and seller 
                       ->get()
                       ->pluck('product.seller')
                       ->unique('id') //avoid repeat a Seller
                       ->values();//avoid spaces in white
        return $this->showAll($sellers);
    }

   
}
