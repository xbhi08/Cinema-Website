<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\customer;
class CustomerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $customer = customer::all();
       return view('index_customer' , ['customers' => $customer]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $storeData = $request->validate([
            'custName' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|max:255',
            'username' => 'required|max:255',
            'gender' => 'required|max:255',
            'password' => 'required|max:255',
            'dateOfBirth' => 'required|max:255'
           
        ]);
        //$customer = customer::create($storeData);
        $customer=customer::create([
            'custName'=>$storeData['custName'],
            'email'=>$storeData['email'],
            'address'=>$storeData['address'],
            'gender'=>$storeData['gender'],
            'username'=>$storeData['username'],
            'dateOfBirth'=>$storeData['dateOfBirth'],
            'password'=>bcrypt($storeData['password'])
        ]);
        return redirect('/customers')->with('success', 'Customer details have been saved!');
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
        $customer = customer::findOrFail($id);
        return view('edit_customer', compact('customer'));
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
           $updateData = $request->validate([
            'custName' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|max:255',
            'username' => 'required|max:255',
            'gender' => 'required|max:255',
            'password' => 'required|max:255',
            'dateOfBirth' => 'required|max:255'
          
        ]);
        customer::where('customerID', $id)->update($updateData);
        return redirect('/rcustomers')->with('success', 'customer details have been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = customer::findOrFail($id);
        $customer->delete();

        return redirect('/customers')->with('success', 'Customer has been deleted');
    }
}