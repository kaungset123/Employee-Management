<?php

namespace App\Http\Controllers\employee;

use Exception;
use Log;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use function App\Helpers\calculateAverageRating;
use function App\Helpers\ratingAvailableCheck;

class RatingController extends Controller
{
    public  $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => 'Rating Management',
            'header' => 'Rating ',
        ];
    }

    public function create(int $id)
    {
        $this->checkPermission('rating create');

        $rater_id = auth()->user()->id;
        $rated_id = $id;
        $rating = ratingAvailableCheck($rater_id,$rated_id);

        if($rating){
            return back()->with('failstatus','you already rated this user for this month');
        }elseif($rater_id == $rated_id) {
            return back()->with('failstatus','you can\'t rate you own!');
        }
        else{
            $user = User::findOrFail($id);
            $rating = calculateAverageRating($user->id);
            // dd($rating);
            $this->data['user'] = $rating;
            return view('employee.rating.index')->with(['data' => $this->data]);
        } 
                 
    }

    public function store(Request $request)
    {
        $this->checkPermission('rating create');

        try{          
            $validated =  $request->validate([
                'rater_id' => 'required',
                'rated_id' => 'required', 
                'rating' => 'required|integer|between:1,5',
            ]);
            Rating::create($validated);
            $userRole = auth()->user()->getRoleNames()->first();
            return response()->json(['success' => 'You rated successfully','role' => $userRole]);
        }catch(Exception $e) {
            return response()->json(['error' => 'Error saving rating. Please try again.'], 500);
        }
    }  
    
    private function checkPermission($permission,$id = null) 
    {
        return $this->authorize($permission,$id);
    }
}
