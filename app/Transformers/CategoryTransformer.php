<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'identificador'   =>  (int)$category->id,
            'title'           =>  (string)$category->name,
            'description'     =>  (string)$category->description,
            'create_at'       =>  (string)$category->created_at,
            'deleted_at'      =>  (string)$category->deleted_at,

            'links' =>  [
                [
                    'rel' => 'self',
                    'href'=> route('categories.show',$category->id),
                ],
                [
                    'rel'   =>  'category.buyers',
                    'href'  =>  route('categories.buyers.index',$category->id)
                ],
                [
                    'rel'   =>  'category.products',
                    'href'  =>  route('categories.products.index',$category->id)
                ],
                [
                    'rel'   =>  'category.transactions',
                    'href'  =>  route('categories.transactions.index',$category->id)
                ],
            ]
        ];
    }

    public static function originalAtrribute($index){
        $attributes = [
            'identificador'   =>  'id',
            'title'           =>  'name',
            'description'     =>  'description',
            'create_at'       =>  'created_at',
            'deleted_at'      =>  'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index){
        $attributes = [
            'id'          =>'identificador',
            'name'        =>'title',
            'description' =>'description',
            'created_at'  =>'create_at',
            'deleted_at'  =>'deleted_at'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
