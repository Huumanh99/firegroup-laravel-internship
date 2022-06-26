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
  {{$count}}
 
  {{-- <a value="pending" id="pd" class="btn btn-primary" onclick="pending('pending')">Pending<sup>{{$pending}}</sup></a>
  <a value="approve" id="ap" class="btn btn-primary" onclick="pending('approve')">Approve<sup>{{$approve}}</sup></a>
  <a value="reject" id="re" class="btn btn-primary" onclick="pending('reject')">Reject<sup>{{$reject}}</sup></a> --}}
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
      <th scope="col">Status</th>
      <th scope="col">User</a></th>
      <th scope="col">Category</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="list_products">
    @foreach ($products as $product)
    <tr>
      <td>{{ $product->id }}</td>
      <td>{{ $product->title }}</td>
      <td>{{ $product->description }}</td>
      <td>{{ $product->quantity }}</td>
      <td><img width="100px" src="/{{$product->image }}" alt="{{ $product->image }}"> </td>
      <td>{{ $product->price }}</td>
      <td>{{ $product->status }} </td>
      <td>{{ $product->user_name}}</td>
      <td>{{ $product->category_title}}</td>
      <td><a href="/products/edit/{{ $product->id }}">Edit</a> | <a
          href="/products/delete/{{ $product->id }}">Delete</a> | <a href="/products/detail/{{ $product->id }}">View</a>
      </td>
    </tr>
    @endforeach
</table>
{{ $products->links() }}

@stop