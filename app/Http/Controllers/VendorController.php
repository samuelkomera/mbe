<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::orderBy('id', 'DESC')->pluck('val');
        return response()->json(json_decode($vendors,true));
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
            $vendorName =(object) [
                  'first'     =>  $request->get('first'),
                  'last'      =>  $request->get('last'),
            ];
            $vendorInfo =(object) [
                  'id'        =>  $this->getNextStatementId(),
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
           return response()->json(['message' => 'Successfully Added Vendor']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::find($id);
        return response()->json($vendor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::find($id);
        return response()->json($vendor);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vendor::find($id)->delete();
        return response()->json([
            'message' => 'Successfully deleted Vendor'
        ]);

    }

    protected function getNextStatementId()
    {
        $nextId = Vendor::orderBy('id', 'desc')->take(1)->first();
        $nextId = json_decode($nextId,true);
        $nextId = $nextId['id'] +1; 
        return $nextId;

    }

}
