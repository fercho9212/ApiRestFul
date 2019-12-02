<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identificador'     =>  (int)$buyer->id,
            'nombre'            =>  (string)$buyer->name,
            'correo'            =>  (string)$buyer->email,
            'esVerificado'      =>  (int)$buyer->verified,
            'fechaCracion'      =>  (string)$buyer->created_at,
            'fechaActualización'=>  (string)$buyer->update_at,
            'fechaEliminación'  =>  isset($buyer->deleted_at) ? (string)$buyer->delete_at:null,
            'links'             =>[
                [
                    'rel'   =>  'self',
                    'href'  =>  route('buyers.show',$buyer->id)
                ],
                [
                    'rel'   =>  'buyer.categories',
                    'href'  =>  route('buyers.categories.index',$buyer->id)
                ],
                [
                    'rel'   =>  'buyer.products',
                    'href'  =>  route('buyers.products.index',$buyer->id)
                ],
                [
                    'rel'   =>  'buyer.sellers',
                    'href'  =>  route('buyers.sellers.index',$buyer->id)
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $buyer->id),
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
