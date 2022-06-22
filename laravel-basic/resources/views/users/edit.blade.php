@extends('layouts.master')

@section('title', 'Edit user')

@section('content')

<h2>Edit user</h2>

<form action="/users/update/{{ $user[0]->id }}" method="post" enctype="multipart/form-data" class="form-horizontal">
  {{ csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-2" for="Name">Name (*):</label>
    <div class="col-sm-6">
      <input type="text" name="name" class="form-control" value="{{ $user[0]->name }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="name">Username(*)</label>
    <div class="col-sm-6">
      <input type="text" name="username" class="form-control" value="{{ $user[0]->username }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Email:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="email" value="{{ $user[0]->email }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Password">Password:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="password" value="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Role">Role:</label>
    <div class="col-sm-6">
      <select name="role" class="form-control" id="role">
        <option value="Admin" @if ($user[0]->role === 'Admin') selected @endif>Admin</option>
        <option value="Guest" @if ($user[0]->role === 'Guest') selected @endif>Guest</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Image">Image:</label>
    <div class="col-sm-6">
      <input type="file" name="image" class="form-control"  placeholder="image">
      {{-- <input type="file" name="image_cu" class="form-control" value = "{{ $user[0]->image }}" placeholder="image"> --}}
      <img src="/{{ $user[0]->image }}" width="300px">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Active">Active:</label>
    <div class="col-sm-6">
      <input type="radio" name="is_active" value="1" @if ($user[0]->is_active === 1) checked @endif>
      <label for="is_active1">Active</label><br>
      <input type="radio" name="is_active" value="0" @if ($user[0]->is_active === 0) checked @endif>
      <label for="is_active0">In-active</label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Save user</button>
    </div>
  </div>
</form>

@stop