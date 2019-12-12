@extends('layouts.tutee')
@section('title', 'eTutor Chats')

@section('page-heading')
    <h1 class="h3 mb-0 text-gray-800">Tutors and conversation</h1>
@endsection

@section('page-content')

    <div class="row">

        <div class="col-lg-12">

            <user-tutor-chats></user-tutor-chats>

        </div>

    </div>
@endsection
