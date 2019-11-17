<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransationController extends ApiController
{
    /**
    * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transactions=$category->products()->with('transactions')
                               ->whereHas('transactions')
                               ->get()
                               ->pluck('transactions')
                               ->collapse();
        return $this->showAll($transactions);
    }

}
