<?php

namespace App\Transformers;

use App\Buyer;
use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identificador'     =>  (int)$seller->id,
            'nombre'            =>  (string)$seller->name,
            'correo'            =>  (string)$seller->email,
            'esVerificado'      =>  (int)$seller->verified,
            'fechaCracion'      =>  (string)$seller->created_at,
            'fechaActualización'=>  (string)$seller->update_at,
            'fechaEliminación'  =>  isset($seller->deleted_at) ? (string)$seller->delete_at:null,
        ];
    }
}
