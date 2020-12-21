<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{

    protected $table = 'coupons_list';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];  
}    

?>    