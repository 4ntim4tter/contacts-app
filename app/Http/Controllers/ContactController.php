<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function __construct(protected CompanyRepository $company)
    {
    }

    public function index(CompanyRepository $company, Request $request)
    {
        $companies = $this->company->pluck();
        // DB::enableQueryLog();
        $contacts = Contact::allowedTrash()
        ->allowedSorts(['first_name', 'last_name', 'email'], "-id")
        ->allowedFilters('company_id')
        ->allowedSearch('first_name', 'last_name', 'email')
        ->paginate(10);
        // dump(DB::getQueryLog());
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

    public function update(Request $request, Contact $contact)
    {
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

    public function edit(Contact $contact)
    {
        $companies = $this->company->pluck();
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function show(Contact $contact)
    {
        $companies = $this->company->pluck();
        return view('contacts.show')->with('contact', $contact)->with('company_name', $companies[$contact->company_id]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')
            ->with('message', 'Contact has been moved to trash.')
            ->with('undoRoute', route('contacts.restore', $contact->id));
    }

    public function restore(Contact $contact)
    {
        $contact->restore();
        return back()
            ->with('message', 'Contact has been restored from trash.')
            ->with('undoRoute', route('contacts.destroy', $contact->id));
    }

    public function forceDelete(Contact $contact)
    {
        $contact->forceDelete();
        return back()
            ->with('message', 'Contact has been removed permanently.');
    }
}
