@extends('layouts.master')

@section('title', 'List of Products')

@section('content')

<h2>List of Products</h2>
<p><a href="/products/create" class="btn btn-primary">Create new products</a></p>
<div class="box-search">
  <form action="/products" method="get">
    <div class="autocomplete" style="width:300px;">
      Tìm kiếm thông tin:<input type="text" name="title" id="searchTitle" list="search"
        placeholder="Tim theo tieu de title..." value="{{ $title }}" />
      <div class="autocomplete-items"></div>
    </div>
    <button type="submit">Tìm kiếm</button>
  </form>
</div>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Title</a></th>
      <th scope="col">Description</th>
      <th scope="col">Quantity</th>
      <th scope="col">Image</th>
      <th scope="col">Price</th>
      <th scope="col">Is_active</th>
      <th scope="col">User_id</a></th>
      <th scope="col">Category_id</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($products as $product)
    <tr>
      <td>{{ $product->id }}</td>
      <td>{{ $product->title }}</td>
      <td>{{ $product->description }}</td>
      <td>{{ $product->quantity }}</td>
      <td>@if ($product->image > 0) <img width="100px" src="/{{ $product->image }}" alt="{{ $product->image }}"> @endif
      <td>{{ $product->price }}</td>
      <td>@if($product->is_active == 0) No @else Yes @endif </td>
      <td>{{ $product->user_name}}</td>
      <td>{{ $product->category_title}}</td>
      <td></td>
      </td>
      <td><a href="/products/edit/{{ $product->id }}">Edit</a> | <a
          href="/products/delete/{{ $product->id }}">Delete</a> | <a href="/products/detail/{{ $product->id }}">View</a>
      </td>
    </tr>
    @endforeach
</table>

@stop
