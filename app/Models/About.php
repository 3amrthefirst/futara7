<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts' ;

    protected $fillable = array('title','content');

    public $timestamps = true ;

}
