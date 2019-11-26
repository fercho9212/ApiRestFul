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
            'identificador'     =>  (int)$category->id,
            'title'          =>  (string)$category->quantity,
            'detalle'         =>  (string)$category->buller_id,
            'create_at'          =>  (string)$category->product_id,
            'updated_at'      =>  (string)$category->created_at,
        ];
    }
}
