@extends('layouts.tutor')
@section('title', 'eTutor Chats')

@section('page-heading')
    <h1 class="h3 mb-0 text-gray-800">Tutee and conversation</h1>
@endsection

@section('page-content')

    <div class="row">

        <div class="col-lg-12">

            <tutor-user-chats></tutor-user-chats>

        </div>

    </div>
@endsection
