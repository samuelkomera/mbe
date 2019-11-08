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
    public function index()
    {
        $cars = Car::pluck('val');
        return response()->json(json_decode($cars,true));
    }
    public function store(Request $request)
    {
        if ($vid = $request->get('vendorid'))
        {   
          $vendor = Vendor::find($vid);
          $vendor = json_decode(json_encode($vendor->val));
        }
        $carInfo =(object) [
              'id'       =>  null,
              'make'        =>  $request->get('make'),
              'model'       =>  $request->get('model'),
              'carnumber'   =>  $request->get('carnumber'),
              'price'       =>  $request->get('price'),
              'vprice'      => null,
              "vendor"      =>  $vendor
          ];
        $car = new Car([
              'vendorid'    =>  $vendor->id,
              'make'        =>  $request->get('make'),
              'model'       =>  $request->get('model'),
              'price'       =>  $request->get('price'),
              'carnumber'   =>  $request->get('carnumber'),
              'val'         =>  json_encode($carInfo, true)
        ]);
        $car->save();
        DB::table('cars') ->where('id', $car->id)
            ->update(['val->id' => $car->id]);

        return response()->json(['message' => 'Successfully Added Car']);

    }
    public function show($id)
    {
        $car = Car::find($id);
        return response()->json($car);
    }
    public function edit($id)
    {
        $car = Car::find($id);
        return response()->json($car);
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy(Request $request, $id)
    {
        Car::find($id)->delete();
            return response()->json([
            'message' => 'Successfully deleted Car'
        ]);
    }
}
