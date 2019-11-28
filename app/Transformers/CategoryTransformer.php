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
            'name'            =>  (string)$category->name,
            'description'     =>  (string)$category->description,
            'create_at'       =>  (string)$category->created_at,
            'deleted_at'      =>  (string)$category->deleted_at,
        ];
    }

    public static function originalAtrribute($index){
        $attributes = [
            'identificador'   =>  'id',
            'name'            =>  'name_id',
            'description'     =>  'description',
            'create_at'       =>  'created_at',
            'deleted_at'      =>  'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
