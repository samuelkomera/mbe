<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
        protected $fillable = [ 
        'val'
        ];  

        protected $table = 'customers';
        
        public function getValAttribute($value)
        {
            return json_decode($value);
        }

}
