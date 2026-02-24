<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        // 修正ボタン
        if ($request->input('action') === 'back') {
            return redirect()
                ->route('contact.index')
                ->withInput($request->all());
        }

        // 送信ボタン
        if ($request->input('action') === 'submit') {
            return $this->store($request);
        }

        $contact = $request->all();
        $categories = Category::all();

        return view('confirm', compact('contact', 'categories'));
    }

    public function store(ContactRequest $request)
    {

        [$last_name, $first_name] = explode('　', $request->name);
        $tel = $request->input('tel1') . '-' . $request->input('tel2') . '-' . $request->input('tel3');

        $form = [
            'name' => $request->name,
            'age' => $request->age,
            'nationality' => $request->country,
            'category_id' => $request->category_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tel' => $tel,
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ];
        Contact::create($form);

        return view('thanks');

    }

}
