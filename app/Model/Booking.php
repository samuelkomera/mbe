<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Car;
use App\Model\Vendor;
use App\Model\Customer;

class Booking extends Model
{
        protected $fillable = [ 
        'vendorid','customerid','make','model', 'start', 'end', 'carnumber','status','val'
        ];  

        protected $table = 'bookings';
            

        public function vendor()
        {   
            return $this->hasOne('App\Model\Vendor','vendorid');
        }   


     public function searchCars($from , $to)
    {
           $dates = $this->getBetweenTimes($from,$to);
//
//           $date=[];
//           foreach($days as $key => $value){
//               $dates = array_push($date, $value);
//           }

             $cars= DB::table('cars')
            ->select(DB::raw('count(*) as total'),'make','model')
            ->where('carstatus', '=', 'available')
            ->groupBy('make','model')
            ->get();
    
             $bookings= DB::table('bookings')->select(DB::raw('count(*) as booked'),'make','model')
            ->where([
                ['start', '<=',date("Y-m-d H:i:s", $from)],
                ['end', '>=', date("Y-m-d H:i:s", $from)],
                ['status','=','booked' ]
            ])
            ->orWhereIn(DB::raw('extract(epoch from start)'), $dates)
            ->groupBy('make','model')
            ->get();
//            $cars  = Car::all();
            $carsAvail=$cars->merge($bookings);
            return $carsAvail;

     }
     public function getBetweenTimes($from, $to) {
        $dates = [];
        while($to <= $from) {
            $dates[] = $from;
            $from++;
        }
        return $dates;
    }
    public function getValAttribute($value)
    {
        return json_decode($value);
    }

    function car(){
        return $this->belongsTo("App\Car","carId");
    }
}
