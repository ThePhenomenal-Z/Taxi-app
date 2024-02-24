<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Resources\DriverResource;
use App\Http\Requests\updateDriverRequest;

class DriverController extends Controller
{
    // constructing policy
    public function __construct()
    {
        $this->authorizeResource(Driver::class, 'driver');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $user = User::findOrFail($userId);
        // Retrieve the associated driver model
        $driver = $user->driver;
        return new DriverResource($driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDriver(updateDriverRequest $request)
    {
        $this->authorize('updateDriver', Driver::class);
        $validated = $request->validated();
        $userId = auth()->id();
        $user = User::find($userId);
        $user->update($validated);
        // Retrieve the associated driver model
        $driver = $user->driver;
        $driver->update($validated);
        return new DriverResource($driver);
    }

}
