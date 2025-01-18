<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserLogActivityResource;
use App\Models\UserLogActivity;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLogActivityController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $log = UserLogActivity::where('user_id', Auth::id())->paginate();
        return $this->success(UserLogActivityResource::collection($log));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserLogActivity $userLogActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserLogActivity $userLogActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserLogActivity $userLogActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserLogActivity $userLogActivity)
    {
        //
    }
}
