<?php

namespace App;
use App\product;
use IlluminatecDatabase\Eloquent\Model;

class Category extends Model
{
    protected $fillable =[
        'name',
        'description'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
