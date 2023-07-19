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
           
          <td>reviewID</td>
          <td>customerID</td>
          <td>showID</td>
          <td>adminID</td>
          <td>comment</td>
          <td>rating</td>
          <td>banned</td>
          <td>flagged</td>
          <td>date_posted</td>
          <td class="text-center">Action</td>
            
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        @if($review->flagged==1 && $review->banned==0)
        <tr>
            <td>{{$review->reviewID}}</td>
            <td>{{$review->customerID}}</td>
            <td>{{$review->showID}}</td>
            <td>{{$review->adminID}}</td>
            <td>{{$review->comment}}</td>
            <td>{{$review->rating}}</td>
            <td>{{$review->banned}}</td>
            <td>{{$review->flagged}}</td>
            <td>{{$review->date_posted}}</td>
            
            <td class="text-center">
                <a href="{{ route('reviews.edit', $review->reviewID)}}" class="btn btn-primary btn-sm">Ban</a>
                <form action="{{ route('reviews.destroy', $review->reviewID)}}" method="post" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                  </form>
            </td>
        </tr>
        
        @endif
        @endforeach
    </tbody>
  </table>
<div>
@endsection