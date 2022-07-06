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
@stop