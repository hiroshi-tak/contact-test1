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

    public function search(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%')
                ->orWhere('last_name', 'like', '%' . $request->name . '%')
                ->orWhere('email', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->simplePaginate(10)->appends($request->query());

        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function reset()
    {
        return redirect()->route('contacts.index');
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
