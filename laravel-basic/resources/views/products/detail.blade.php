@extends('layouts.master')

@section('title', 'List of Users')

@section('content')

<h2>Products detail</h2>
<ul>
  @if($product[0]->image > 0)
  <li><img width="150px" src="/{{ $product[0]->image }}" alt="{{ $product[0]->image }}"></li>
  @endif
  <li>ID: {{ $product[0]->id }}</li>
  <li>Title: {{ $product[0]->title }}</li>
  <li>Description: {{ $product[0]->description }}</li>
  <li>Quantity: {{ $product[0]->quantity }}</li>
  <li>Image: {{ $product[0]->image }}</li>
  <li>Price: {{$product[0]->price }}</li>
  <li>Actived: {{$product[0]->is_active }}</li>
  <li>UserID: {{$product[0]->user_id }}</li>
  <li>CategoryID: {{$product[0]->category_id }}</li>
  
</ul>
@stop
