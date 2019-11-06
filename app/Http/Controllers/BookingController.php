<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\Booking;
use App\Model\Customer;
use App\Model\Staff;
use App\Model\Primary;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::pluck('val');
        return response()->json(json_decode($bookings,true));
    }
    public function updateStatus(Request $request) {
        $booking = new Booking(); 
        $bookingInfo = $booking->load($request->id);
        $primary = new Primary($bookingInfo);
        if($request->status) {
            $primary->head->status = $request->status;
        }
        return $primary;
    }
    public function addTran(Request $request) {
        $cn = $request->cn;
        $type = $request->type;
        $amount = $request->amount;
        $booking = new Booking(); 
        $bookingInfo = $booking->load($request->id);
        $primary = new Primary($bookingInfo);
        $primary->transactions->add($cn,$type,$amount);
        return $primary;
    }
    public function book(Request $request)
    {
        if(!$request->get('availability')) {
            return response()->json(['message' => 'Cannot be booked - Unavailable']);
        }
        $starttime   = date("Y-m-d H:i:s", $request->starttime);
        $endtime   = date("Y-m-d H:i:s", $request->endtime);
        $bookingInfo = Primary::create($request, $this->getNextStatementId());
        $booking = new Booking([
          'make'        =>  $request->get('make'),
          'model'       =>  $request->get('model'),
          'start'       =>  $starttime,
          'end'         =>  $endtime,
          'val'         =>  json_encode($bookingInfo, true)
        ]);
        $booking->save();
       return response()->json(['message' => 'Successfully Booked a Car']);
    }
    public function search(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $bookingSearch = new Booking(); 
        $cars= $bookingSearch->searchCars($from,$to);
        return response()->json($cars);
    }
    public function store(Request $request)
    {
    }
    public function show($id)
    {   
        $booking = Booking::where('id',$id)->pluck('val');
        return response()->json($booking);
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy($id)
    {
    }
   protected function getNextStatementId()
    {
        $nextId = Booking::orderBy('id', 'desc')->take(1)->first();
        $nextId = json_decode($nextId,true);
        $nextId = $nextId['id'] +1; 
        return $nextId;

    }

}
