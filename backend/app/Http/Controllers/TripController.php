<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
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

    public function show(Request $request,Trip $trip){
        return new TripResource($trip);
    }

    public function accept(Request $request,Trip $trip){
        if($trip->status!='waiting'){
            return response()->json([
                "message"=>"ivalid button pressed"
            ],400);
        }
        $trip->status="accepted";
        $user_id=auth()->id();
        $user=User::find($user_id);  
        $trip->driver_id=$user->driver->id;
        return response()->json([
            "message"=>"trip accepted by the driver {$trip->driver->name}"
        ]);  
    }
    public function start(Request $request,Trip $trip){
        if($trip->status!='accepted'){
            return response()->json([
                "message"=>"ivalid button pressed"
            ],400);
        }
        $trip->status="started";
        return response()->json([
            "message"=>"trip started by the driver {$trip->driver->name} to {$trip->destination_name}"
        ]);  
    }
    public function complete(Request $request,Trip $trip){
        if($trip->status!='started'){
            return response()->json([
                "message"=>"ivalid button pressed"
            ],400);
        }
        $trip->status="completed";
        return response()->json([
            "message"=>"trip has ended and it costs {$trip->price}"
        ]);  
    }
    public function location(){
        
    }
}
