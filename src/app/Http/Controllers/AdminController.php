<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact; // Contactモデルを使えるようにする

class AdminController extends Controller
{
    public function index()
    {
        // 1. データベースから全てのデータを取ってくる
        $contacts = Contact::all();

        // 2. admin.blade.php を表示する（その際、$contacts を渡す）
        return view('admin', compact('contacts'));
    }
}
