<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
        protected $fillable = [ 
        'first','last','val'
        ];  

        protected $table = 'vendors';
        
        public function getValAttribute($value)
        {
            return json_decode($value);
        }

           protected $casts = [
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp'
          ];

}
