<?php

namespace App\Models;

use App\Traits\GetAttribute;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use GetAttribute ;

    protected $table = "bills" ;

    public $timestamps = true ;

    protected $fillable = [
      'company_id' ,
      'client_id' ,
      'final_price' ,
      'tax_amount' ,
        'price_before_tax',
        'payment_type'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class , 'bills_products')->withPivot('quantity');
    }

    public function getPaymentTypeAttribute()
    {
        if ( $this->attributes['payment_type'] == 1)
        {
            return 'Cash' ;
        }elseif ($this->attributes['payment_type'] == 2 )
        {
            return 'Visa' ;
        }elseif ($this->attributes['payment_type'] == 3)
        {
            return 'Mada';
        }
    }
}
