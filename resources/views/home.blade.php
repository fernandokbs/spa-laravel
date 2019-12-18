@extends('layouts.app')

@section('content')
    <App :user='@json(auth()->user()->getApiData())'></App>
@endsection
