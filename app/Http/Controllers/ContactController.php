<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __construct(protected CompanyRepository $company)
    {
    }

    public function index(CompanyRepository $company, Request $request)
    {
        $companies = $this->company->pluck();

        $contacts = Contact::allowedTrash()
        ->allowedSorts('first_name')
        ->allowedFilters('company_id')
        ->allowedSearch('first_name', 'last_name', 'email')
        ->paginate(10);
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        // dd(request()->method());
        $companies = $this->company->pluck();
        $contact = new Contact;
        return view('contacts.create', compact('companies', 'contact'));
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
        $contact = Contact::findOrFail($id);
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id'
        ]);
        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfuly.');
    }

    public function edit($id)
    {
        $companies = $this->company->pluck();
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function show($id)
    {
        $companies = $this->company->pluck();
        $contact = Contact::findOrFail($id);
        return view('contacts.show')->with('contact', $contact)->with('company_name', $companies[$contact->company_id]);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts.index')
            ->with('message', 'Contact has been moved to trash.')
            ->with('undoRoute', route('contacts.restore', $contact->id));
    }

    public function restore($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->restore();
        return back()
            ->with('message', 'Contact has been restored from trash.')
            ->with('undoRoute', route('contacts.destroy', $contact->id));
    }

    public function forceDelete($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();
        return back()
            ->with('message', 'Contact has been removed permanently.');
    }
}
