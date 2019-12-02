<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
     *s
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identificador'     =>  (int)$transaction->id,
            'cantidad'          =>  (string)$transaction->quantity,
            'comprador'         =>  (string)$transaction->buller_id,
            'producto'          =>  (string)$transaction->product_id,
            'fechaCracion'      =>  (string)$transaction->created_at,
            'fechaActualizacion'=>  (string)$transaction->update_at,
            'fechaEliminacion'  =>  isset($transaction->deleted_at) ? (string)$transaction->delete_at:null,
            'links' =>  [
                [
                    'rel' => 'self',
                    'href'=> route('transactions.show',$transaction->id),
                ],
                [
                    'rel'   =>  'transaction.categories',
                    'href'  =>  route('transactions.categories.index',$transaction->id)
                ],
                [
                    'rel'   =>  'transaction.seller',
                    'href'  =>  route('transactions.sellers.index',$transaction->id)
                ],
/*                 [
                    'rel'   =>  'buyer',
                    'href'  =>  route('buyers.show',$transaction->buller_id),
                ], */
                [
                    'rel'   =>  'product',
                    'href'  =>  route('products.show',$transaction->product_id),
                ]
            ]
        ];
    }

    public static  function originalAtrribute($index){
        $attributes = [
            'identificador'     =>  'id',
            'cantidad'          =>  'quantity',
            'comprador'         =>  'buller_id',
            'producto'          =>  'product_id',
            'fechaCracion'      =>  'created_at',
            'fechaActualizacion'=>  'update_at',
            'fechaEliminacion'  =>  'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
