<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerControler extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
        $this->middleware('can:view,buyer')->only('show'); //can:view permiso buyer instaciona del Police BUyer
    }

    public function index()
    {
        $this->allowedAdminAction();
        $compradores=Buyer::has('transactions')->get();  //has recibe el nombre de la relacion
        return $this->showAll($compradores);
    }
    public function show(Buyer $buyer)
    {  //has recibe el nombre de la relacion
        return $this->showOne($buyer);
    }
 
}
