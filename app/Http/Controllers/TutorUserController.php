<?php

namespace App\Http\Controllers;

use App\TutorUser;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TutorUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param Request $request
     */
    public function indexJson(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TutorUser  $tutorUser
     * @return \Illuminate\Http\Response
     */
    public function show(TutorUser $tutorUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TutorUser  $tutorUser
     * @return \Illuminate\Http\Response
     */
    public function edit(TutorUser $tutorUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TutorUser  $tutorUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TutorUser $tutorUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TutorUser  $tutorUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(TutorUser $tutorUser)
    {
        //
    }


    /**
     * @param Request $request
     * @param User $tutor
     * @param User $tutee
     * @return JsonResponse
     */
    public function assignTutorToTutee(Request $request, User $tutor, User $tutee)
    {
        $assignment = TutorUser::assignTutee($tutor, $tutee, $request->user()->id);

        $status = $assignment ? true : false;

        return response()->json(['status' => $status]);
    }
}
