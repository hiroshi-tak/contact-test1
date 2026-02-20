<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        // $contacts = Contact::with('category')->get();
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(Request $request)
    {
        $tel = $request->input('tel1') . '-' . $request->input('tel2') . '-' . $request->input('tel3');
        $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'address', 'building','category_id','detail']);
        return view('confirm', compact('contact','tel'));
    }

    public function store(Request $request)
    {
/*

        $contact = $request->only(['gender', 'email', 'tel','address', 'building','detail']);
        Contact::create($contact);
*/
        [$last_name, $first_name] = explode('　', $request->name);

        $genderMap = [
            '男性' => 1,
            '女性' => 2,
            'その他' => 3,
        ];

        $genderNumber = $genderMap[$request->gender];

        $form = [
            'name' => $request->name,
            'age' => $request->age,
            'nationality' => $request->country,
            'category_id' => $request->category_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'gender' => $genderNumber,
            'email' => $request->email,
            'tel' => $request->tel,
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ];
        Contact::create($form);

        return view('thanks');

    }

}
