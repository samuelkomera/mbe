<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::pluck('val');
        return response()->json(json_decode($customers,true));
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
            $customerName =(object) [
                  'first'     =>  $request->get('first'),
                  'last'      =>  $request->get('last'),
              ];
            $customerInfo =(object) [
                  'id'              =>  $this->getNextStatementId(),
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
           return response()->json(['message' => 'Successfully Added Customer']);

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
        $customer = Customer::find($id);
        return response()->json($customer);
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
        Customer::find($id)->delete();
            return response()->json([
            'message' => 'Successfully deleted Customer'
        ]);

    }

    protected function getNextStatementId()
    {
        $next_id = \DB::select("select nextval('customers_id_seq')");
        return intval($next_id['0']->nextval) + 1;
    }

}
