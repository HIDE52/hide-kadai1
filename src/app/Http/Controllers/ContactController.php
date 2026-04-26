<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $contact = $request->only(['first_name', 'last_name', 'email', 'gender', 'address', 'building', 'category_id', 'detail']);
        $contact['tel'] = $request->tel1 . $request->tel2 . $request->tel3;

        Contact::create($contact);
        return view('thanks');
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }

    private function getSearchQuery(Request $request)
    {
        $query = Contact::with('category');

        if ($request->filled('keyword')) {
            $keyword = str_replace([' ', '　'], '', $request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhereRaw('CONCAT(last_name, first_name) LIKE ?', ["%{$keyword}%"]);
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

        return $query;
    }

    public function search(Request $request)
    {
        $query = $this->getSearchQuery($request);
        $contacts = $query->paginate(7);
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function export(Request $request)
    {
        $query = $this->getSearchQuery($request);

        $csvHeader = ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類', 'お問い合わせ内容'];

        $response = new StreamedResponse(function () use ($query, $csvHeader) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $csvHeader);

            $query->chunk(100, function ($contacts) use ($handle) {
                foreach ($contacts as $contact) {
                    $gender = $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他');
                    fputcsv($handle, [
                        $contact->last_name . $contact->first_name,
                        $gender,
                        $contact->email,
                        $contact->category->content,
                        $contact->detail,
                    ]);
                }
            });

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contacts_' . date('Ymd') . '.csv"',
        ]);

        return $response;
    }
}
