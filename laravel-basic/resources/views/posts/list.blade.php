@extends('layouts.master')

@section('title', 'List of Users')
@section('styles')

@stop

@section('content')

<h2>List of Posts</h2>
@foreach ($count as $countStatus)
<a class="btn btn-primary"
  onclick = "filterByStatus('{{$countStatus->status}}')">{{$countStatus->status}}
  <sup>{{$countStatus->stt}}</sup>
</a>
@endforeach
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Content</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="list_posts">
    @foreach ($posts as $post)
    <tr>
      <td>{{ $post->id }}</td>
      <td><img width="100px" src="{{$post->image }}" alt="{{ $post->image }}"> </td>
      <td>{{ $post->title }}</td>
      <td>{{ $post->content }}</td>
      <td>
        <div class="form-group">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input"
             {{($post->status==='publish') ? 'checked' : ''}}
               onclick="changeUserStatus(event.target,{{$post->id}});">
            <label class="custom-control-label pointer"></label>
         </div>
      </div>
      </td>
      <td><a href="/posts/edit/{{ $post->id }}">Edit</a> | <a
          href="/posts/delete/{{ $post->id }}">Delete</a> |
        <a href="/posts/detail/{{ $post->id }}">View</a>
      </td>
    </tr>
    @endforeach
</table>
{!! $posts->links() !!}

@stop
