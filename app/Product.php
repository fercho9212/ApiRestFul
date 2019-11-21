<?php

namespace App;
use App\Seller;
use App\Category;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const PRODUCTO_DISPONIBLE='disponible';
    const PRODUCTO_NO_DISPONIBLE='no disponible';
    protected $dates = ['deleted_at'];
    protected $fillable=[
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];
    //public $timestamps = false;
    const UPDATED_AT = null;
    protected $hidden =[
        'pivot'
    ];

    public function estaDisponible(){
        return $this->status==Product::PRODUCTO_DISPONIBLE;
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function setNameAttribute($valor){
        $this->attributes['name'] = strtolower($valor);
    }
/*     public function setCreatedAtAttribute($date) {
        $this->attributes['created_at'] = Carbon::parse($date)->format('M j Y h:i:s');
    }
    public function setUpdatedAttribute($date) {
        $this->attributes['updated_at'] = Carbon::parse($date)->format('M j Y h:i:s');
    }
    public function setDeletedAttribute($date) {
        $this->attributes['deleted_at'] = Carbon::parse($date)->format('M j Y h:i:s');
    }
    public function getCreatedAtAttribute($date) {
        return  Carbon::parse($date)->format('M j Y h:i:s');
    }
    public function getUpdatedAttribute($date) {
        return Carbon::parse($date)->format('M j Y h:i:s');
    }
   */ public function getDeletedAttribute($date) {
        return Carbon::parse($date)->format('M j Y h:i:s');
    }
}
