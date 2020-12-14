<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{

    public function index()
    {

        $users = User::orderBy('name', 'asc')->get();
        //dd($users);
        // var_dump($users[0]['name']);

        return response()->json([
            'users' => $users,
        ], 200);

    }

}
