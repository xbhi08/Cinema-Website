@extends('layout')

@section('content')

<style>
  .push-top {
    margin-top: 50px;
  }
</style>

<div class="push-top">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <table class="table">
    <thead>
        <tr class="table-warning">
          <td>customerID</td>
          <td>Name</td>
          <td>Email</td>
          <td>address</td>
          <td>Username</td>
          <td>Date of Birth</td>
          <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <td>{{$customer->customerID}}</td>
            <td>{{$customer->custName}}</td>
            <td>{{$customer->email}}</td>
            <td>{{$customer->address}}</td>
            <td>{{$customer->username}}</td>
            <td>{{$customer->dateOfBirth}}</td>
            
            <td class="text-center">
                <form action="{{ route('customers.destroy', $customer->customerID)}}" method="post" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                  </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection