<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;
use Error;
use GuzzleHttp\Psr7\Message;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactController extends Controller
{
    public function __construct(protected CompanyRepository $company)
    {

    }

    public function index(CompanyRepository $company, Request $request)
    {
        // dd($request->sort_by);
        // $companies = [
        //     1 => ['name' => 'Company One', 'contacts' => 3],
        //     2 => ['name' => 'Company Two', 'contacts' => 5],
        // ];

        $companies = $this->company->pluck();
        // $contacts = Contact::latest()->paginate(10);
        $contacts = Contact::latest()->where(function ($query){
            if ($companyId = request()->query('company_id'))
            {
                $query->where("company_id", $companyId);
            }
        })->paginate(10);

        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        $edit = false;
        // dd(request()->method());
        $companies = $this->company->pluck();
        return view('contacts.create', compact('companies'))->with('edit', $edit);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id'
        ]);
        Contact::create($request->all());
        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfuly.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id'
        ]);
        Contact::findOrFail($id)->update(array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company_id' => $request->company_id
        ));
        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfuly.');
    }

    public function edit($id)
    {
        $edit = true;
        $companies = $this->company->pluck();
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('companies'))->with('contact', $contact)->with('edit', $edit)->with('selected_id', $contact->company_id);
    }

    public function show($id)
    {

        $contact = Contact::findOrFail($id);
        return view('contacts.show')->with('contact', $contact);
    }
}
