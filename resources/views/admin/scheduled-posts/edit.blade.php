@extends('admin.layout')
@section('title', 'Editar Post')
@section('content')
    <form method="POST" action="{{ route('admin.scheduled-posts.update', $scheduledPost) }}">
        @method('PUT')
        @include('admin.scheduled-posts._form')
    </form>
@endsection
