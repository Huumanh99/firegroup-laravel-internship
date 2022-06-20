@extends('layouts.master')

@section('title', 'List of Users')
@section('styles')

@stop

@section('content')

<h2>List of Users</h2>
<p><a href="/users/create" class="btn btn-primary">Create new user</a></p>
<div class="box-search">
  <form action="/users" method="get" id="seachForm">
    <div class="autocomplete" style="width:300px;">
      Tìm kiếm thông tin:<input type="text" name="name" id="searchName" list="search"
        placeholder="Tim theo tieu de name..." value="{{ $name }}" />
      <div class="autocomplete-items"></div>
    </div>
    <button type="submit">Tìm kiếm</button>
  </form>
</div>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col"><a href="/users?sortName={{ $sortName }}">Name</a></th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Image</th>
      <th scope="col">Activated</th>
      <th scope="col"><a href="/users?sortrole={{ $sortrole }}">Role (Admin / Guest)</a></th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
    <tr>
      <td>{{ $user->id }}</td>
      <td><a title="{{ $user->name }}">{{ $user->name }}</a></td>
      <td><a title="{{ $user->username }}">{{ $user->username }}</a></td>
      <td>{{ $user->email }}</td>
      <td>
         <img width="100px" src="/{{$user->image }}" alt="{{ $user->image }}"> 
      </td>
      {{-- <td>{{ $user->image }}</td> --}}
      <td>@if($user->is_active == 0) No @else Yes @endif </td>
      <td>{{ $user->role }}</td>
      <td><a href="/users/edit/{{ $user->id }}">Edit</a> | <a
          href="/users/delete/{{ $user->id }}">Delete</a> |
        <a href="/users/detail/{{ $user->id }}">View</a>
      </td>
    </tr>
    @endforeach
</table>
{{ $users->links() }}

@stop
