@extends('layouts.master')

@section('title', 'List of Users')

@section('content')

<h2>User detail</h2>
<ul>
  {{-- @if($user[0]->image > 0) --}}
  <li><img width="150px" src="/{{ $user[0]->image }}" alt="{{ $user[0]->image }}"></li>
  {{-- @endif --}}
  <li>ID: {{ $user[0]->id }}</li>
  <li>Name: {{ $user[0]->name }}</li>
  <li>Email: {{ $user[0]->email }}</li>
  <li>Role: {{ $user[0]->role }}</li>
  <li>Active: {{$user[0]->is_active }}</li>
</ul>

@stop
