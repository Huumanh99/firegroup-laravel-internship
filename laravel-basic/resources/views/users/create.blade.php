@extends('layouts.master')

@section('title', 'List of Users')

@section('content')

<h2>Create user</h2>
<form action="/users/create-user" method="post" enctype="multipart/form-data" class="form-horizontal" id="createForm">
  {{ csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-2" for="name">Name <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="name">Username <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Email <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Password">Password <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Role">Role <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <select name="role" class="form-control" id="role">
        <option value="Admin">Admin</option>
        <option value="Guest">Guest</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Image">Image:</label>
    <div class="col-sm-6">
      <input type="file" name="image" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Active">Active <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <label class="radio-inline"><input type="radio" name="is_active" value="1" checked>Yes</label>
      <label class="radio-inline"><input type="radio" name="is_active" value="0">No</label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Create user</button>
    </div>
  </div>
</form>

@stop