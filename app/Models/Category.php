<?php

namespace App\Models;

use App\Traits\GetAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use GetAttribute , SoftDeletes;
    protected $table = "categories";
    public $timestamps = true ;
    protected $fillable=[
        'company_id',
        'title'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class , 'category_id');
    }



}
