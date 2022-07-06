@extends('layouts.master')

@section('title', 'Edit post')

@section('content')

<h2>Edit post</h2>
<form action="/posts/update/{{ $post[0]->id }}" method="post" enctype="multipart/form-data"
  class="form-horizontal">
  {{ csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-2" for="title">Title<span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="title" class="form-control" value="{{ $post[0]->title }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Description">Description <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <textarea rows="4" cols="50" class="form-control" name="description">{{ $post[0]->description }}</textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Content">Content <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="text" name="content" class="form-control" value="{{ $post[0]->content }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Image">Image <span class="text-danger">(*)</span>:</label>
    <div class="col-sm-6">
      <input type="file" name="image" class="form-control"  placeholder="image">
      <img src="{{ $post[0]->image }}" width="300px">
    </div>
  </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Save post</button>
    </div>
  </div>
</form>
@stop