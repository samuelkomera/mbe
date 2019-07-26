<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\Booking;
use App\Model\Customer;
use App\Model\Car;
use App\Model\Staff;
use App\Model\booking\Head;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function book(Request $request)
    {
        if(!$request->get('availability')) {
            return response()->json(['message' => 'Cannot be booked - Unavailable']);
        }
        $from   = date("Y-m-d H:i:s", $request->from);
        $to   = date("Y-m-d H:i:s", $request->to);
        $carInfo = (object) [
                  'make'        =>  $request->get('make'),
                  'model'       =>  $request->get('model'),
        ];
        $bookingInfo =(object) [
              'bookingId'   =>  $this->getNextStatementId(),
              "car"         =>  $carInfo,
              "customer"    =>  null,
              "staff"       =>  null,
              "check"       =>  null,
              "transactions" => null,    
          ];
        $booking = new Booking([
//              'vendorid'    =>  $vendor->id, 
//              'customerid'  =>  $customer->id,
          'make'        =>  $request->get('make'),
          'model'       =>  $request->get('model'),
          'start'        =>  $from,
          'end'          =>  $to,
          'val'         =>  json_encode($bookingInfo, true)
        ]);
        $booking->save();
       return response()->json(['message' => 'Successfully Booked a Car']);
    }

    // Search the availability of cars
    public function search(Request $request)
    {
        //
        $from = $request->from;
        $to = $request->to;
        $bookingSearch = new Booking(); 
        $cars= $bookingSearch->searchCars($from,$to);
        return response()->json($cars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   protected function getNextStatementId()
    {
        $next_id = \DB::select("select nextval('bookings_id_seq')");
        return intval($next_id['0']->nextval);
    }

}
