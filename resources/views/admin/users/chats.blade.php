@extends('layouts.admin')
@section('title', 'eTutor Chats')

@section('page-heading')
    <h1 class="h3 mb-0 text-gray-800">Chats</h1>
@endsection

@section('page-content')

    <div class="row">

        <div class="col-lg-12">

            <etutor-users-chats></etutor-users-chats>

        </div>

    </div>
@endsection
