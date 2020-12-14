<?php

namespace App\Http\Controllers;

use App\User;
use DB;

class AdminController extends Controller
{

    public function userList()
    {
        $users = \App\User::all(); //var_dump($users);

        $users = DB::select('SELECT users.id AS id, users.name AS name , email, users.created_at AS created_at,  COUNT(file_uploads.id) AS pictures  FROM  users ,file_uploads    WHERE users.id =  file_uploads.user_id GROUP BY id ORDER BY pictures  DESC');

        //  var_dump($users);

        return \View::make('admin/userlist')->with(array('users' => $users));
    }

    public function imageList($id)
    {

        $changeuserid = $id;

        return \View::make('admin/imagelist')->with(array('changeuserid' => $changeuserid));
    }

}
