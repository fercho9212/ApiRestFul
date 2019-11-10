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
    public function index()
    {
        $compradores=Buyer::has('transactions')->get();  //has recibe el nombre de la relacion
        return $this->showAll($compradores);
    }
    public function show($id)
    {
        $compradores=Buyer::has('transactions')->findOrFail($id);  //has recibe el nombre de la relacion
        return $this->showOne($compradores);
    }
 
}
