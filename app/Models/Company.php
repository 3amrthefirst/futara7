<?php

namespace App\Models;

use App\Traits\GetAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use GetAttribute , HasApiTokens , SoftDeletes;
    protected $table = "companies";
    public $timestamps = true ;
    protected $fillable = [
        'name',
        'fire_base_id',
        'subscribe_id',
        'subscription_end_date',
        'email',
        'password',
        'phone',
        'tax_rate',
        'tax_number',
        'address'
    ];

    protected $hidden = [
        'password' , 'deleted_at',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function category()
    {
        return $this->hasMany(Category::class , 'company_id');
    }
    public function product()
    {
        return $this->hasManyThrough(
            Product::class ,
            Category::class ,
            'company_id' ,
            'category_id');
    }
    public function client()
    {
        return $this->hasMany(Category::class , 'company_id');
    }
    public function subscribe()
    {
       return $this->belongsTo(Subscribtion::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class , 'company_id');
    }

    public function quickBills()
    {
        return $this->hasMany(Bill::class , 'company_id');
    }
}
