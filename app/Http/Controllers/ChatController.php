<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.chats');
    }

    public function indexJson(Request $request, User $from, User $to)
    {
        $messages = Chat::with(['fromUser', 'toUser'])
            ->where('to', $to->id)
            ->orWhere('from', $from->id)
            ->latest()
            ->get();

        return response()->json($messages);
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
     * @param \Illuminate\Http\Request $request
     * @param User $to
     * @return void
     */
    public function store(Request $request, User $to)
    {
        $this->validate($request, [
            'message' => 'required|string|max:280',
            'attachment' => 'nullable|file'
        ]);

        try {
            $attachment = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $attachment = $file->storeAs(
                    'chat-files',
                    $file->hashName(). '.' .
                    $file->getClientOriginalExtension());
            }

            $chatMessage = $request->user()
                ->sendMessage($to, $attachment);

            $status = $chatMessage ? true : false;

            return response()->json(['status' => $status]);

        } catch (\Exception $exception) {
            Log::info($exception->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Could not upload your claim. Try again later'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
