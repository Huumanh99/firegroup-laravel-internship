@extends('layouts.master')

@section('title', 'Edit product')

@section('content')

<h2>Edit product</h2>
<form action="/shopify/update/{{ $product[0]->id }}" method="post" enctype="multipart/form-data"
  class="form-horizontal">
  {{ csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-2" for="body_html">Body_html<span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="body_html" class="form-control" value="{{ $product[0]->body_html }}" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="title">Title<span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="title" class="form-control" value="{{ $product[0]->title }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="handle">Handle <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <textarea rows="4" cols="50" class="form-control" name="handle">{{ $product[0]->handle }}</textarea>
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
    <label class="control-label col-sm-2" for="status">Status <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <select name="status" class="form-control" id="status">
        <option value="pending">Active</option>
        <option value="approve">is_active</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Save product</button>
    </div>
  </div>
</form>
@stop