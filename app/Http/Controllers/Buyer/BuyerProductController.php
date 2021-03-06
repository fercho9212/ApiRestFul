<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    
    public function __construct(){
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
        $this->middleware('can:view,buyer')->only('index'); //can:view permiso buyer instaciona del Police BUyer
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        /**$buyer->transactions->product It's relactions but laravel convert transactions how a colection */ 
        $products=$buyer->transactions() //CALL function no relaction, transacions() equas query builder 
                        ->with('product') //to access relactions with with(), get product for every transactions 
                        ->get() //obtain for method get, it is displayed a Collections with all transactions and prudctus 
                        ->pluck('product');//obtain only products of that relactions return $this->showAll($products);
        return $this->showAll($products);
    }
}
