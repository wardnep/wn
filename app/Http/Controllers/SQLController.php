<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class SQLController extends Controller
{
    public function index()
    {
        return view('sql.index');
    }

    public function execution(Request $request)
    {
        $sql = $request->sql;
        $connection = $request->connection;

        $results = DB::connection($connection)->select($sql, []);
        $headers = array_keys((array) $results[0]);

        return view('sql.index', compact('sql', 'connection', 'results', 'headers'));
    }
}
