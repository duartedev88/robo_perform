@extends('admin.layout')
@section('title', 'Novo Post Agendado')
@section('content')
    <form method="POST" action="{{ route('admin.scheduled-posts.store') }}">
        @include('admin.scheduled-posts._form')
    </form>
@endsection
