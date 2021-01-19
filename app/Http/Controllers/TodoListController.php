<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;
use DB;

class TodoListController extends Controller
{
    public function index()
    {
        return view('todolist');
    }
}
