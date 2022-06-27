<?php

use function Symfony\Component\String\s;

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

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

        $users =  $queryUsers->paginate(5); //->get();

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
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' =>  'required',
            'username' =>  'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please enter the correct fields');
            return redirect()->back();
        }
        $imageName = "";
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $imageURL = "images/" . $imageName;

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
        $user = User::find($id);
        $imageUser = $user->image;

        $imageURL = "";
        if ($_FILES['image']['name'] != "") {
            $imageUser = $_FILES['image']['name'];
            $request->image->move(public_path('images'), $imageUser);
            $imageURL = "images/" . $imageUser;
        } else {
            $imageURL =  $imageUser;
        }

        $userData = [
            'image' => $imageURL,
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'is_active' => $request->input('is_active'),
        ];

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

    public function export()
    {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=galleries.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = User::all()->toArray();

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }
}
