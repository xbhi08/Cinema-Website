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
    Edit & Update
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
      <form method="post" action="{{ route('reviews.update', $review->reviewID) }}">
          <div class="form-group">
              @csrf
              @method('PATCH')
              <label for="banned">Ban</label>
              <input type="number" class="form-control" name="banned" min="0" max="1" value="{{ $review->banned }}"/>
          </div>

          <button type="submit" class="btn btn-block btn-danger">Update review</button>
      </form>
  </div>
</div>
@endsection