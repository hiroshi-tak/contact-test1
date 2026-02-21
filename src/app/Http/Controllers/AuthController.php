<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class AuthController extends Controller
{
    public function admin()
    {
        $contacts = Contact::simplePaginate(10);
        //$contacts = Contact::Paginate(10);
        //$contacts = Contact::all();
        $categories = Category::all();
        return view('admin', compact('contacts','categories'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $content = Contact::with('category')->findOrFail($id);
        return response()->json([
            'first_name' => $contact->first_name,
            'last_name' => $contact->last_name,
            'gender' => $contact->gender,
            'email' => $contact->email,
            'tel' => $contact->tel,
            'address' => $contact->address,
            'building' => $contact->building,
            'category' => optional($content->category)->content, 
            'detail' => $contact->detail,
        ]);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json(['success' => true]);
    }
}
