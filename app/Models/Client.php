<?php

namespace App\Models;

use App\Traits\GetAttribute;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use LogTrait,GetAttribute;

    public $guard_name = 'clients';

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name','phone','tax_number','company_id');

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class , 'client_id');
    }

}
