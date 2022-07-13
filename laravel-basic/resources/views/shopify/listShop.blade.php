@extends('layouts.master')

@section('title', 'List of Products')

@section('content')

<h2>List of Shopify</h2>
<p><a href="/shopify/createShopify" class="btn btn-primary">Create new products</a></p>
<div class="box-search">
    <form action="/shopify" method="get">
        <label for="name">Shop name: </label>
        <input type="text" id="name" name="name">
        {{ csrf_field()}}
        <button type="submit" value="Submit">Submit</button>
    </form>
</div>
<div>
  <a href="/api/createWebhook">createWebhook</a>
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
        <td>{{ $product->status }} </td>   
        <td><img width="10px" src="{{$product->image }}" alt="{{ $product->image }}"> </td>
        <td><a href="/shopify/edit/{{ $product->id }}">Edit</a> | <a
            href="/api/shopify/delete/{{ $product->id }}">Delete</a>
        </td>
      </tr>
      @endforeach
  </table>
@stop