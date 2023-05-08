<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickBill extends Model
{
    protected $table = "quick_bills";
    public $timestamps = true ;
    protected $fillable = [
        'company_id' ,
        'name' ,
        'price',
        'tax' ,
        'final_price',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
