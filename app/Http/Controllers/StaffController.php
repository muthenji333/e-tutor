<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Log;
use App\Role;
use App\TutorUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.users.index');
    }

    public function indexJson(Request $request)
    {
        $userRole = strtolower($request->input('role', 'tutee'));

        switch ($userRole) {
            case 'staff':
                $users = User::with(['role', 'tutees', 'tutors'])->where('role_id', 2)->get();
                break;
            case 'tutor':
                $users = User::with(['role', 'tutees', 'tutors'])->where('role_id', 3)->get();
                break;
            case 'tutee':
                $users = User::with(['role', 'tutees', 'tutors'])->where('role_id', 4)->get();
                break;
            default:
                $users = User::with(['role', 'tutees', 'tutors'])->get();
        }

        return response()->json($users);

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
        $this->validate($request, [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|unique:users',
            'role' => 'required|size:36'
        ]);

        $role = Role::where('uuid', $request->role)->first();

        if (!$role) {
            return response()->json(['status' => false]);
        }
        $password = Str::random(8);
        $userEmail = $request->input('email');
        $userName = $request->input('name');

        $userInstance = User::create([
            'role_id' => $role->id,
            'name' => $userName,
            'email' => $userEmail,
            'password' => Hash::make($password),
        ]);

        $userInstance->createLog('Account created');

        $emailSubject = config('app.name') . ' account creation credentials';
        $emailMessage = "Hello $userName, your account has been created successfully.\n"
            ."\nYour credentials are:"
            ."\temail: $userEmail"
            ."\tpassword: $password"
            ."\n\nKindly change the your password on your first login."
            ."This password will be reset automatically if it is not changed after 24hrs(".now()->addDay().")";

        $task = "Account creation email sent to $userEmail";
        $this->dispatch(new SendEmailJob($userInstance, $emailSubject, $emailMessage, $task));

        return response()->json(['status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'false' => true,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $status = $user->delete();

        return response()->json(['status' => $status ? true : false]);
    }

    public function tutorWithTutees(Request $request)
    {
        $usersWithTutees = User::with('tutees')
            ->where('role_id', 3)
            ->get();

        return response()->json($usersWithTutees);
    }

    /**
     * Returns tutees for this tutor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tutees(Request $request)
    {
        return response()->json($request->user()->tutees());
    }

    public function tutor(Request $request)
    {
        return response()->json($request->user()->tutors, 204);
    }

    public function assignTutorToTutees(Request $request)
    {
        try {
            $data = file_get_contents('php://input');

            $postData = json_decode($data);

            $tutor = User::where('uuid', $postData->tutor)->first();

            $tuteesUuids = $postData->tutees;

            foreach ($tuteesUuids as $tuteesUuid) {
                $tutee = User::where('uuid', $tuteesUuid)->first();

                $exist = TutorUser::where([['tutor_id' , $tutor->id],['user_id', $tutee->id]])->first();

                if (!$exist) {
                    $tutee->createTutor($tutor, $request->user()->id);
                    $emailSubject = 'You have been assigned a Tutor!';
                    $emailMessage = "Hello $tutee->name, you have been assignd a tutor..\n"
                        ."\nLogin to your account and interract:"
                        ."\tTutor name: $tutor->name"
                        ."\tTutor email $tutor->email"
                        ."\n\nAll the best!.";
                    $task = "$tutee->name assigned tutor $tutor->name($tutor->email)";
                    $this->dispatch(new SendEmailJob($tutee, $emailSubject, $emailMessage, $task));
                }
            }

            return response()->json(['status' => true]);
        } catch (\Exception $exception) {
            \Illuminate\Support\Facades\Log::info($exception->getMessage());
            return response()->json(['status' => false]);
        }
    }
}
