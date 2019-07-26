<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\Car;
use App\Model\Vendor;


class CarController extends Controller
{

//    public function __construct()
//    {  
//          $this->middleware('auth:api', ['except' => ['addCar']]);
//    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $cars = Car::all();
//        $cars = Car::select('val')->pluck('val');
        $cars = Car::pluck('val');
        return response()->json(json_decode($cars,true));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($vid = $request->get('vendorid'))
        {   
          $vendor = Vendor::find($vid);
          $vendor = json_decode(json_encode($vendor->val));
        }
        // select extract(epoch from created_at) from users;
            $carInfo =(object) [
                  'carId'       =>  $this->getNextStatementId(),
                  'make'        =>  $request->get('make'),
                  'model'       =>  $request->get('model'),
                  'carnumber'   =>  $request->get('carnumber'),
                  "vendor"      =>  $vendor
              ];
            $car = new Car([
              'vendorid'    =>  $vendor->id,
              'make'        =>  $request->get('make'),
              'model'       =>  $request->get('model'),
              'carnumber'   =>  $request->get('carnumber'),
              'val'         =>  json_encode($carInfo, true)
            ]);
            $car->save();
           return response()->json(['message' => 'Successfully Added Car']);

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
        $car = Car::find($id);
        return response()->json($car);
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
    public function destroy(Request $request, $id)
    {
        //Car::find('name',$name)->delete();
        Car::find($id)->delete();
            return response()->json([
            'message' => 'Successfully deleted Car'
        ]);
    }
    protected function getNextStatementId()
    {
        $next_id = \DB::select("select nextval('cars_id_seq')");
        return intval($next_id['0']->nextval) + 1;
    }
}
