@extends('layouts.master')

@section('title', 'List of Users')

@section('content')

<h2>Products detail</h2>
<ul>
  <li>ID: {{ $post[0]->id }}</li>
  <li><img width="150px" src="{{ $post[0]->image }}" alt="{{ $post[0]->image }}"></li>
  <li>Content: {{ $post[0]->content }}</li>  
  <li>Title: {{ $post[0]->title }}</li>
  <li>Description: {{ $post[0]->description }}</li>
</ul>
@stop
