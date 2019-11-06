<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    //
        protected $fillable = [ 
        'vendorid','make','model','price','carnumber','carstatus','val'
        ];  

        protected $table = 'cars';
        
        public function getValAttribute($value)
        {
            return json_decode($value);
        }

        public function vendor()
        {
            return $this->hasOne('App\Model\Vendor','vendorid');
        }

}
