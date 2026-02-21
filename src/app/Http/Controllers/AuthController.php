<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
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

    public function export(Request $request)
    {
        // 検索条件を保持
        $query = Contact::query();

        if ($request->name) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->name}%")
                ->orWhere('last_name', 'like', "%{$request->name}%")
                ->orWhere('email', 'like', "%{$request->name}%");
            });
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->with('category')->get();

        // CSV ヘッダー
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');

            // 1行目にカラム名（Shift_JIS に変換）
            fputcsv($file, mb_convert_encoding(['名前', '性別', 'メールアドレス', 'お問い合わせの種類'], 'SJIS-win', 'UTF-8'));

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    mb_convert_encoding($contact->last_name . ' ' . $contact->first_name, 'SJIS-win', 'UTF-8'),
                    mb_convert_encoding($contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'), 'SJIS-win', 'UTF-8'),
                    mb_convert_encoding($contact->email, 'SJIS-win', 'UTF-8'),
                    mb_convert_encoding(optional($contact->category)->content, 'SJIS-win', 'UTF-8'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
