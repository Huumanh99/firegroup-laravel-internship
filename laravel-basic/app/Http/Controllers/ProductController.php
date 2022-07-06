<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        $countStatus = DB::table('products')
            ->select(DB::raw('count(status) as stt, status'))
            ->groupBy('status')
            ->get();

        $queyProducts = DB::table('products')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'users.name as user_name', 'categories.title as category_title');

        // search by title 
        $title = $request->get('title');
        if (strlen($title) > 0) {
            $queyProducts->where('products.title', 'like', '%' . $title . '%');
        }

        $products = $queyProducts->paginate(5);

        return view(
            'products.list',
            [
                'count' => $countStatus,
                'authUser' => $authUser,
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
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' =>  'required',
            'title' =>  'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please enter the correct fields');
            return redirect()->back();
        }

        $imageName = "";
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $imageURL = "images/" . $imageName;

        DB::table('products')->insert(
            [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'quantity' => $request->input('quantity'),
                'status' => $request->input('status'),
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
        $user = Product::find($id);
        $imageUser = $user->image;

        $imageURL = "";
        if ($_FILES['image']['name'] != "") {
            $imageUser = $_FILES['image']['name'];
            $request->image->move(public_path('images'), $imageUser);
            $imageURL = "images/" . $imageUser;
        } else {
            $imageURL =  $imageUser;
        }

        DB::table('products')->where('id', $id)
            ->update(
                [
                    'user_id' => $request->input('user_id'),
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'quantity' => $request->input('quantity'),
                    'status' => $request->input('status'),
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
    public function fitter(Request $request)
    {
        $status = DB::table('products')->where('status', '=', $request->keyword)->get();
        return response()->json([
            'code' => 200,
            'keyword' => $status,
        ]);
    }

    public function pageUser(Request $request)
    {
        return view('products.pageUser');
    }
}
