@extends('layout')

@section('content')

<style>
    .container {
      max-width: 450px;
    }
    .push-top {
      margin-top: 50px;
    }
</style>

<div class="card push-top">
  <div class="card-header">
    Add customer
  </div>

  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('customers.store') }}">
           
      <div class="form-group">
              <label for="customerID">ID</label>
              <input type="number" class="form-control" name="customerID" value="{{ old('customerID') }}"/>
          </div>

          <div class="form-group">
              @csrf
              <label for="custName">Name</label>
              <input type="text" class="form-control" name="custName" value="{{ old('custName') }}"/>
          </div>
          <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" value="{{ old('email') }}"/>
          </div>
          <div class="form-group">
              <label for="address">address</label>
              <input type="text" class="form-control" name="address" value="{{ old('address') }}"/>
          </div>
          <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" value="{{ old('username') }}"/>
          </div>

          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" value="{{ old('password') }}"/>
          </div>

          <div class="form-group">
              <label for="dateOfBirth">Date Of Birth</label>
              <input type="date" class="form-control" name="dateOfBirth" value="{{ old('dateOfBirth') }}"/>
          </div>

          <div class="form-group">
              <label for="gender">Gender</label>
              <input type="text" class="form-control" name="gender" value="{{ old('gender') }}"/>
          </div>
          <button type="submit" class="btn btn-block btn-danger">Create customer</button>
      </form>
  </div>
</div>
@endsection