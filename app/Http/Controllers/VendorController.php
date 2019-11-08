<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vendor;
use DB;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('id', 'DESC')->pluck('val');
        return response()->json(json_decode($vendors,true));
    }
    public function store(Request $request)
    {
        $vendorName =(object) [
              'first'     =>  $request->get('first'),
              'last'      =>  $request->get('last'),
        ];
        $vendorInfo =(object) [
              'id'        =>  null,
              'name'      =>  $vendorName,
              'phonenumber'=> $request->get('phonenumber'),
              'email'      => $request->get('email')
        ];
        $vendor = new Vendor([
          'first'     =>  $request->get('first'),
          'last'      =>  $request->get('last'),
          'val'       =>  json_encode($vendorInfo, true)
        ]);
        $vendor->save();
        DB::table('vendors') ->where('id', $vendor->id)
        ->update(['val->id' => $vendor->id]);
        return response()->json(['message' => 'Successfully Added Vendor']);

    }
    public function show($id)
    {
        $vendor = Vendor::find($id);
        return response()->json($vendor);
    }
    public function edit($id)
    {
        $vendor = Vendor::find($id);
        return response()->json($vendor);
    }
    public function update(Request $request, $id)
    {
        $vendorName =(object) [
              'first'     =>  $request->get('first'),
              'last'      =>  $request->get('last'),
        ];
        $vendorInfo =(object) [
              'id'        =>  $id,
              'name'      =>  $vendorName,
              'phonenumber'=> $request->get('phonenumber'),
              'email'      => $request->get('email')
        ];
        $vendor = [
              'first'     =>  $request->get('first'),
              'last'      =>  $request->get('last'),
              'val'       =>  json_encode($vendorInfo, true)
        ];
        Vendor::where('id', $id)->update($vendor);
        return response()->json([
              'message' => 'Successfully Updated Vendor'
        ]);
    }
    public function destroy($id)
    {
        Vendor::find($id)->delete();
        return response()->json([
            'message' => 'Successfully deleted Vendor'
        ]);

    }
}
