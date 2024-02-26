<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;
use App\Http\Requests\storeTripRequest;

class TripController extends Controller
{
    public function store(storeTripRequest $request){
        
        $validatedData = $request->validated();
        json_decode($validatedData["origin"]);
        json_decode($validatedData["destination"]);
        $validatedData["user_id"]= auth()->id();
        $trip = Trip::create($validatedData);
        return new TripResource($trip);
    }
}
