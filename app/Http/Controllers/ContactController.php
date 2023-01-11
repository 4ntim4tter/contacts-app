<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    protected function userCompanies()
    {
        return Company::forUser(auth()->user())->orderBy('name')->pluck('name', 'id');
    }

    public function index()
    {
        $companies = $this->userCompanies();
        // DB::enableQueryLog();
        $contacts = Contact::allowedTrash()
        ->allowedSorts(['first_name', 'last_name', 'email'], "-id")
        ->allowedFilters('company_id')
        ->allowedSearch('first_name', 'last_name', 'email')
        ->forUser(auth()->user())
        ->paginate(10);
        // dump(DB::getQueryLog());
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        // dd(request()->method());
        $companies = $this->userCompanies();
        $contact = new Contact;
        return view('contacts.create', compact('companies', 'contact'));
    }

    public function store(ContactRequest $request)
    {
        $request->user()->contacts()->create($request->all());
        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfuly.');
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfuly.');
    }

    public function edit(Contact $contact)
    {
        $companies = $this->userCompanies();
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function show(Contact $contact)
    {
        $companies = $this->userCompanies();
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
