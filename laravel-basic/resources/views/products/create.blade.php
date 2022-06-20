@extends('layouts.master')

@section('title', 'List of Users')

@section('content')

<h2>Create product</h2>
<form action="/products/create-product" method="post" enctype="multipart/form-data" class="form-horizontal" id="create-product">
  {{ csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-2" for="title" id = "title">Title <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Description">Description <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <textarea rows="4" cols="50" class="form-control" name="description" id="description"></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Quantity">Quantity <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Enter quantity">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Image">Image <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="file" name="image">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Price">Price <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="number" name="price" class="form-control" id="price" placeholder="Enter price">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="status">Status <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <select name="status" class="form-control" id="status">
        <option value="pending">Pending</option>
        <option value="approve">Approve</option>
        <option value="reject">Reject</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="user_id">User:</label>
    <div class="col-sm-6">
      <select name="user_id" class="form-control" id="user_id">
        <option value="1">Manh</option>
        <option value="2">Anna</option>
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
