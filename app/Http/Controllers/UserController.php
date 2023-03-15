<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('isAdmin');
    // }

    public function index()
    {
        $users=User::all();
        return view('users.index',['users'=>$users]);
    }

    public function create()
    {
        
        return view('users.create');
    }


    public function store(Request $request)
    {
        $request->validate([

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
            'role' => ['required', 'integer', 'in:0,1'],
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','user deleted successfully');
    }
}
