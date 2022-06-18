<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //List of products
        $queyProducts = DB::table('products')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'users.name as user_name', 'categories.title as category_title');

        // search by title 
        $title = $request->get('title');
        if (strlen($title) > 0) {
            $queyProducts->where('products.title', 'like', '%' . $title . '%');
        }

        $products = $queyProducts->get();
        
        return view(
            'products.list',
            [
                'title' => $title,
                'products' => $products,
                'currentPage' => 'products'
            ]
        );
    }

    public function create()
    {
        return view(
            'products.create',
            [
                'currentPage' => 'products'
            ]
        );
    }

    public function createProduct(Request $request)
    {
        $imageURL = "";
        if ($request->hasFile('images')) {
            $imageName = strtolower(time() . '.' . $request->image->getClientOriginalName());
            $request->image->move(public_path('images'), $imageName);
            $imageURL = "images/" . $imageName;
        }

        DB::table('products')->insert(
            [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'quantity' => $request->input('quantity'),
                'is_active' => $request->input('is_active'),
                'image' => $imageURL,
                'user_id' => $request->input('user_id'),
                'category_id' => $request->input('category_id'),
                'price' => $request->input('price')
            ]
        );

        return redirect()->route('products');
    }

    public function edit($id)
    {
        $product = DB::table('products')->where('id', '=', $id)->get();
        return view(
            'products.edit',
            [
                'product' => $product,
                'currentPage' => 'products'
            ]
        );
    }

    // Update values into DB
    public function update(Request $request, $id)
    {
        // TODO: check uploaded image
        $imageURL = "";
        if ($request->hasFile('images')) {
            $imageName = strtolower(time() . '.' . $request->image->getClientOriginalName());
            $request->image->move(public_path('images'), $imageName);
            $imageURL = "images/" . $imageName;
        }

        DB::table('products')->where('id', $id)
            ->update(
                [

                    'user_id' => $request->input('user_id'),
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'quantity' => $request->input('quantity'),
                    'is_active' => $request->input('is_active'),
                    // TODO: check uploaded image
                    'image' => $imageURL,
                    'category_id' => $request->input('category_id'),
                    'price' => $request->input('price')
                ]
            );

        // Redirect to tasks url
        return redirect()->route('products');
    }

    public function detail($id)
    {
        $product = DB::table('products')->get();
        return view('products.detail', [
            'product' => $product,
            'currentPage' => 'products',
        ]);
    }

    public function delete(Request $request, $id)
    {
        DB::table('products')->where('id', $id)->delete();

        return redirect()->route('products');
    }

    public function search(Request $request)
    {
        $title = trim($request->input('title'));
        if (strlen($title) > 0) {
            $products = DB::table('products')->where('title', 'LIKE', '%' . $title . '%')->get('title');
        } else {
            $products = [];
        }
        return  response()->json($products);
    }
}
