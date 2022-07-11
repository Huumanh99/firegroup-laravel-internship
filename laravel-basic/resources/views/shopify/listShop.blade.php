@extends('layouts.master')

@section('title', 'List of Products')

@section('content')

<h2>Please enter the name of the shop to search</h2>
<div class="box-search">
    <form action="/shopify" method="get">
        <label for="name">Shop name: </label>
        <input type="text" id="name" name="name">
        {{ csrf_field()}}
        <button type="submit" value="Submit">Submit</button>
    </form>
</div>
<table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Body_html</a></th>
        <th scope="col">Title</a></th>
        <th scope="col">Handle</th>
        <th scope="col">Status</th>
        <th scope="col">Image</a></th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody id="list_products">
      @foreach ($products as $product)
      <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->body_html }}</td>
        <td>{{ $product->title }}</td>
        <td>{{ $product->handle }}</td>
        <td><img width="100px" src="/{{$product->image }}" alt="{{ $product->image }}"> </td>
        <td>{{ $product->status }} </td>   
        <td><a href="/shopify/edit/{{ $product->id }}">Edit</a> | <a
            href="/api/shopify/delete/{{ $product->id }}">Delete</a> | <a href="/shopify/detail/{{ $product->id }}">View</a>
        </td>
      </tr>
      @endforeach
  </table>
@stop