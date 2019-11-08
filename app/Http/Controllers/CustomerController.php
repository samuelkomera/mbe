<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::pluck('val');
        return response()->json(json_decode($customers,true));
    }
    public function store(Request $request)
    {
        $customerName =(object) [
              'first'     =>  $request->get('first'),
              'last'      =>  $request->get('last'),
          ];
        $customerInfo =(object) [
              'id'              =>  null,
              'name'            =>  $customerName,
              'mobilenumber'    =>  $request->get('mobilenumber'),
              'email'           =>  $request->get('email'),
              'dob'             =>  $request->get('dob'),
              'address'         =>  $request->get('address'),
              'state'           =>  $request->get('state'),
              'pincode'         =>  $request->get('pincode'),
              'dlnumber'        =>  $request->get('dlnumber'),
              'poi'             =>  $request->get('poi'),
              'doi'             =>  $request->get('doi'),
              'doe'             =>  $request->get('doe'),
          ];
        $customer = new Customer([
          'val'       =>  json_encode($customerInfo, true)
        ]);
        $customer->save();
        DB::table('customers') ->where('id', $customer->id)
        ->update(['val->id' => $customer->id]);

       return response()->json(['message' => 'Successfully Added Customer']);

    }
    public function show($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }
    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        Customer::find($id)->delete();
            return response()->json([
            'message' => 'Successfully deleted Customer'
        ]);

    }
}
