<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $queryUsers = DB::table('users');

        // search by name
        $name = $request->get('name');

        if (strlen($name) > 0) {
            $queryUsers->where('name', 'like', '%' . $name . '%');
        }

        //sort Name and role
        $sortName = strtolower($request->get('sortName'));
        $sortrole = strtolower($request->get('sortrole'));
        if (strlen($sortName) > 0) {
            $queryUsers->orderBy('name', $sortName)->get();
        } else if (strlen($sortrole) > 0) {
            $queryUsers->orderBy('role', $sortrole)->get();
        }

        $users =  $queryUsers->get();

        return view('users.list', [
            'users' => $users,
            'name' => $name,
            'sortName' => $sortName == 'desc' ? 'asc' : 'desc',
            'sortrole' => $sortrole == 'desc' ? 'asc' : 'desc',
            'currentPage' => 'users',
        ]);
    }

    public function create(Request $request)
    {
        return view('users.create', [
            'currentPage' => 'users'
        ]);
    }

    public function createUser(Request $request)
    {
        // check uploaded image
        $imageURL = "";
        if ($request->hasFile('image')) {
            $imageName = strtolower(time() . '.' . $request->image->getClientOriginalName());
            $request->image->move(public_path('images'), $imageName);
            $imageURL = "images/" . $imageName;
        }

        DB::table('users')->insert(
            [
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role' => $request->input('role'),
                'image' => $imageURL,
                'is_active' => $request->input('is_active'),
            ]
        );

        return redirect()->route("users");
    }

    // Router get: /users/{id}
    public function edit($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->get();

        return view(
            'users.edit',
            [
                'user' => $user,
                'currentPage' => 'users'
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $userData = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'is_active' => $request->input('is_active'),
        ];

        // check uploaded image
        if ($request->hasFile('image')) {
            $imageName = strtolower(time() . '.' . $request->image->getClientOriginalName());
            $request->image->move(public_path('images'), $imageName);
            $imageURL = "images/" . $imageName;
            $userData['image'] = $imageURL;
        }

        // check input password
        $password = trim($request->input('password'));
        if (strlen($password) > 0) {
            $userData['password'] = bcrypt($password);
        }

        DB::table('users')->where('id', $id)->update($userData);

        return redirect()->route('users');
    }

    public function delete(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->delete();

        return redirect()->route("users");
    }

    public function detail(Request $request, $id)
    {
        $user = DB::table('users')->where('id', '=', $id)->get();
        return view(
            'users.detail',
            [
                'user' => $user,
                'currentPage' => 'users'
            ]
        );
    }

    public function search(Request $request)
    {
        $name = $request->input('name');
        if (strlen($name) > 0) {
            $users = DB::table('users')->where('name', 'LIKE', '%' . $name . '%')->get('name');
        } else {
            $users = [];
        }
        return  response()->json($users);
    }
}
