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
 
    public function load($id) {
        $booking = Booking::where('id',$id)->pluck('val');
        $primary = new Primary($booking[0]);
        return $primary;
    } 

    public function searchCars($from , $to)
    {

            $cars= DB::table('cars')
            ->select(DB::raw('count(*) as total'),'make','model','price')
            ->where('carstatus', '=', 'available')
            ->groupBy('make','model','price')
            ->get();
    
            $bookings= DB::table('bookings')->select(DB::raw('count(*) as booked'),'make','model')
            ->where(function ($query) use ($from,$to) {
                    $query->where('start', '>=', date("Y-m-d H:i:s", $from))
                          ->where('end', '<=', date("Y-m-d H:i:s", $to))
                          ->where('start', '<=', date("Y-m-d H:i:s", $to))
                          ->where('end', '>=', date("Y-m-d H:i:s", $from))
                          ->where('status','!=','closed');
               })
            ->orWhere(function ($query) use ($from,$to) {
                    $query->where('start', '<=', date("Y-m-d H:i:s", $from))
                          ->where('end', '<=', date("Y-m-d H:i:s", $to))
                          ->where('start', '<=', date("Y-m-d H:i:s", $to))
                          ->where('end', '>=', date("Y-m-d H:i:s", $from))
                          ->where('status','!=','closed');
               })
            ->orWhere(function ($query) use ($from,$to) {
                    $query->where('start', '>=', date("Y-m-d H:i:s", $from))
                          ->where('end', '>=', date("Y-m-d H:i:s", $to))
                          ->where('start', '<=', date("Y-m-d H:i:s", $to))
                          ->where('end', '>=', date("Y-m-d H:i:s", $from))
                          ->where('status','!=','closed');
               })
            ->orWhere(function ($query) use ($from,$to) {
                    $query->where('start', '<=', date("Y-m-d H:i:s", $from))
                          ->where('end', '>=', date("Y-m-d H:i:s", $to))
                          ->where('start', '<=', date("Y-m-d H:i:s", $to))
                          ->where('end', '>=', date("Y-m-d H:i:s", $from))
                          ->where('status','!=','closed');
               })
            ->groupBy('make','model')
            ->get();
            $carsAvail = $this->getAvailableCars($cars,$bookings);
            return $carsAvail;

     }
    public function getAvailableCars($cars,$bookings){
        $available = [];
        if (count($bookings)) {
            foreach($cars as $car) {
                foreach($bookings as $booking){
                    $temp = (object)[];
                    if($car->make == $booking->make && $car->model == $booking->model) {
                        $total = $car->total - $booking->booked;
                        $total = ($total > 0) ? $total : 0;
                        $temp->total    = $total; 
                        $temp->make     = $car->make; 
                        $temp->model    = $car->model; 
                        $temp->price    = $car->price; 
                    } else {
                        $temp = $car; 
                    }
                    $available[] = $temp;
                }
            }
            return $available;
        } else {
            return $cars;
        }

    }
    public function getValAttribute($value)
    {
        return json_decode($value);
    }

    function car(){
        return $this->belongsTo("App\Car","carId");
    }
}
