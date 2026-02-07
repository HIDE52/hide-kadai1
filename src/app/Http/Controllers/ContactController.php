<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'email', 'tel1', 'tel2', 'tel3', 'gender', 'address', 'building', 'category_id', 'detail']);

        $categories = Category::all();

        return view('confirm', compact('contact', 'categories'));
    }

    public function store(Request $request)
    {
        $tel = $request->tel1 . '-' . $request->tel2 . '-' . $request->tel3;

        $contact = $request->only(['first_name', 'last_name', 'email', 'tel1', 'tel2', 'tel3', 'gender', 'address', 'building', 'category_id', 'detail']);

        $contact['tel'] = $tel;

        Contact::create($contact);

        return view('thanks');
    }
}
