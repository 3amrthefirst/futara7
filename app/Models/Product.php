<?php

namespace App\Models;

use App\Traits\GetAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use GetAttribute , SoftDeletes;
    protected $table="products";
    public $timestamps = true ;
    protected $fillable=[
      'title' ,
      'price' ,
      'optional_price',
      'category_id',
        'is_tax',
    ];

    protected $hidden = ['image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bill()
    {
        return $this->belongsToMany(Bill::class , 'bills_products')->withPivot('quantity');
    }

}
