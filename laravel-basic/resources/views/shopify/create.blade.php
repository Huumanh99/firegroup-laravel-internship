@extends('layouts.master')

@section('title', 'List of Users')

@section('content')

<h2>Create product</h2>
@if(Session::has('error'))
  <div class="alert alert-danger" id='error'>{{Session::get('error') }}</div>
@endif
<form action="/shopify/createProductLocal" method="post" enctype="multipart/form-data" class="form-horizontal" id="create-product">
  {{ csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-2" for="body_html">Body_html<span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="body_html" class="form-control" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="title">Title<span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="title" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="handle">Handle <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <textarea rows="4" cols="50" class="form-control" name="handle"></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Image">Image <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="file" name="image" class="form-control"  placeholder="image">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="status">Status <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <select name="status" class="form-control" id="status">
        <option value="pending">Active</option>
        <option value="approve">Is_active</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Create Product</button>
    </div>
  </div>
</form>

@stop
