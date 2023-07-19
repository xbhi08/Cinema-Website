<?php

namespace App\Http\Controllers;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$review=DB::table('reviews')->get();
       $review = review::all();
       return view('index_reviews' , ['reviews' => $review]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_review');
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
           // 'reviewID' => 'required|max:255',
           // 'customerID' => 'required|max:255',
           // 'showID' => 'required|max:10',
           // 'adminID' => 'required|max:10',
           // 'comment' => 'required|max:10',
            'banned' => 'required|max:1',
            //'flagged' => 'required|max:1'
            //'email' => 'required|email|max:255',
            //'date_posted' => 'required|max:255'
            
           
        ]);
        $review = review::create($storeData);

        return redirect('/reviews')->with('success', 'Review details have been saved!');
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
       //$review=DB::table('reviews')->get();
        $review = review::findOrFail($id);
        return view('edit_reviews', compact('review'));
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
            //'reviewID' => 'required|max:255',
            //'customerID' => 'required|max:255',
           // 'showID' => 'required|max:10',
            //'adminID' => 'required|max:10',
            //'comment' => 'required|max:10',
            'banned' => 'required|max:1',
            //'flagged' => 'required|max:1'
            //'email' => 'required|email|max:255',
            //'date_posted' => 'required|max:255'
            
        ]);
        review::where('reviewID', $id)->update($updateData);
        return redirect('/reviews')->with('success', 'review details have been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //$review=DB::table('reviews')->get();
      $review = review::findOrFail($id);
        $review->delete();

        return redirect('/reviews')->with('success', 'review has been deleted');
    }
}
