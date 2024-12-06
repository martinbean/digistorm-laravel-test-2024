<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contacts\StoreContactRequest;
use App\Http\Requests\Contacts\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $contacts =  Contact::query()
            ->when($request->query('search'), fn (Builder $query, string $value) => $query->whereFullText(
                columns: [
                    'first_name',
                    'last_name',
                    'company_name',
                ],
                value: $value,
                boolean: 'or',
            ))
            ->paginate(5);

        return view('contacts.index', compact('contacts'));
    }

    public function create(): View
    {
        return view('contacts.create');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $contact = DB::transaction(function () use ($request): Contact {
            $contact = Contact::query()->create($request->safe()->except('number'));

            foreach (array_filter($request->input('number', default: [])) as $number) {
                $contact->phoneNumbers()->create([
                    'number' => $number,
                ]);
            }

            return $contact;
        });

        return redirect()->route('contacts.show', compact('contact'));
    }

    public function show(Contact $contact): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact): View
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $contact->loadMissing('phoneNumbers');

        $contact = DB::transaction(function () use ($request, $contact): Contact {
            $contact->fill($request->safe()->except('number'));

            // Remove any existing phone numbers not submitted in the request
            foreach ($contact->phoneNumbers as $phoneNumber) {
                if (! in_array($phoneNumber->number, $request->input('number', default: []))) {
                    $phoneNumber->delete();
                }
            }

            // Add any new phone numbers submitted in the request
            foreach ($request->input('number', default: []) as $number) {
                $alreadyAssigned = $contact->phoneNumbers->firstWhere('number', $number);

                if (empty($alreadyAssigned) && ! empty($number)) {
                    $contact->phoneNumbers()->create([
                        'number' => $number,
                    ]);
                }
            }

            $contact->save();

            return $contact;
        });

        return redirect()->route('contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index');
    }
}
