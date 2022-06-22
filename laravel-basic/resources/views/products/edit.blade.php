@extends('layouts.master')

@section('title', 'Edit product')

@section('content')

<h2>Edit product</h2>
<form action="/products/update/{{ $product[0]->id }}" method="post" enctype="multipart/form-data"
  class="form-horizontal">
  {{ csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-2" for="title">Title<span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="title" class="form-control" value="{{ $product[0]->title }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Description">Description <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <textarea rows="4" cols="50" class="form-control" name="description">{{ $product[0]->description }}</textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Quantity">Quantity <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="quantity" class="form-control" value="{{ $product[0]->quantity }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Image">Image <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="file" name="image" class="form-control"  placeholder="image">
      <img src="/{{ $product[0]->image }}" width="300px">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Price">Price <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="price" value="{{ $product[0]->price }}">
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
    <label class="control-label col-sm-2" for="user_id">UserID<span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <select name="user_id" class="form-control" id="user_id">
        <option value="1" @if ($product[0]->user_id === 1) selected @endif>Manh</option>
        <option value="2" @if ($product[0]->user_id === 2) selected @endif>Anna</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Category_id">CategoryID <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <select name="category_id" class="form-control">
        <option value="1" @if ($product[0]->category_id === 1)selected @endif>Phone</option>
        <option value="2" @if ($product[0]->category_id === 2)selected @endif>TV</option>
        <option value="3" @if ($product[0]->category_id === 3)selected @endif>Laptop</option>
      </select>
    </div>
  </div>

  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Save product</button>
    </div>
  </div>
</form>
@stop