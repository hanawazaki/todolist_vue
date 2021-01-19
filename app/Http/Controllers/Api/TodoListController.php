<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TodoListController extends Controller
{
    public function getList()
    {
        // $search = request("search");

        $result = DB::table("todolists");
        if (request("search")) {
            $result->where("content", "like", "%" . request('search') . "%");
        }

        $result = $result->orderBy("id", "desc")->get();

        return response()->json($result);
    }

    public function postList()
    {
        $content = request("content");
        DB::table("todolists")
            ->insert([
                'created_at' => date('Y-m-d H:i:s'),
                'content' => $content
            ]);

        return response()->json(['status' => true, 'message' => 'data berhasil ditambahkan!']);
    }

    public function postUpdate($id)
    {
        $content = request("content");
        DB::table("todolists")
            ->where("id", $id)
            ->update([
                'created_at' => date('Y-m-d H:i:s'),
                'content' => $content
            ]);

        return response()->json(['status' => true, 'message' => 'data berhasil diubah!']);
    }

    public function delete($id)
    {
        $content = request("content");
        DB::table("todolists")
            ->where("id", $id)
            ->delete();

        return response()->json(['status' => true, 'message' => 'data berhasil dihapus']);
    }

    public function editData($id)
    {
        $row = DB::table("todolists")
            ->where("id", $id)
            ->first();

        return response()->json($row);
    }
}
