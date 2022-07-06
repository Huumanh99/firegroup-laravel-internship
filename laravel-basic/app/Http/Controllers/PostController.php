<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();
        $countStatus = DB::table('posts')
            ->select(DB::raw('count(status) as stt, status'))
            ->groupBy('status')
            ->get();

        $posts = Post::paginate(25);

        return view('posts.list', [
            'posts' => $posts,
            'count' => $countStatus,
            'authUser' => $authUser,
            'currentPage' => 'posts',
        ]);
    }

    public function edit($id)
    {
        $post = DB::table('posts')->where('id', '=', $id)->get();
        return view(
            'posts.edit',
            [
                'post' => $post,
                'currentPage' => 'posts'
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $imagePost = $post->image;

        $imageURL = "";
        if ($_FILES['image']['name'] != "") {
            $imagePost = $_FILES['image']['name'];
            $request->image->move(public_path('images'), $imagePost);
            $imageURL = "images/" . $imagePost;
        } else {
            $imageURL =  $imagePost;
        }

        $postData = [
            'image' => $imageURL,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'description' => $request->input('description'),
        ];

        DB::table('posts')->where('id', $id)->update($postData);

        return redirect()->route('posts');
    }

    public function delete(Request $request, $id)
    {
        DB::table('posts')->where('id', $id)->delete();

        return redirect()->route("posts");
    }

    public function detail(Request $request, $id)
    {
        $post = DB::table('posts')->where('id', '=', $id)->get();
        return view(
            'posts.detail',
            [
                'post' => $post,
                'currentPage' => 'posts'
            ]
        );
    }

    public function changeStatus(Request $request)
    {
        $post = Post::find($request->id)->update(['status' => $request->status]);

        return response()->json([
            'success' => 'Status changed successfully',
            'post' => $post,
        ]);
    }

    public function fitter(Request $request)
    {
        $publish = DB::table('posts')->where('status', '=', $request->keyword)->get();
        return response()->json([
            'code' => 200,
            'keyword' => $publish,
        ]);
    }
}
