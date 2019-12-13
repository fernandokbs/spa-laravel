@extends('layouts.app')

@section('content')
    <App :user="{{ auth()->user() }}"></App>
@endsection
