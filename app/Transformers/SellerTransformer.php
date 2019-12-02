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
            'links'             =>[
                [
                    'rel'   =>  'self',
                    'href'  =>  route('sellers.show',$seller->id)
                ],
                [
                    'rel'   =>  'seller.buyers',
                    'href'  =>  route('sellers.buyers.index',$seller->id)
                ],
                [
                    'rel'   =>  'seller.categories',
                    'href'  =>  route('sellers.categories.index',$seller->id)
                ],
                [
                    'rel'   =>  'seller.products',
                    'href'  =>  route('sellers.products.index',$seller->id)
                ],
                [
                    'rel' => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $seller->id),
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $seller->id),
                ],
            ]
        ];
    }

    public static function originalAtrribute($index){
        $attributes = [
            'identificador'     =>  'id',
            'nombre'            =>  'name',
            'correo'            =>  'email',
            'esVerificado'      =>  'verified',
            'esAdministrador'   =>  'admin',
            'fechaCracion'      =>  'created_at',
            'fechaActualización'=>  'update_at',
            'fechaEliminación'  =>  'delete_at'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
