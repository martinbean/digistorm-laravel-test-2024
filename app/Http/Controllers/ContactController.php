<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contacts\StoreContactRequest;
use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $contacts =  Contact::paginate(5);

        return view('contacts.index', compact('contacts'));
    }

    public function create(): View
    {
        return view('contacts.create');
    }

    /**
     * @throws \Throwable
     */
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

    public function edit(Contact $contact): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact): Response
    {
        $contact->fill($request->all());

        foreach ($contact->phoneNumbers as $phoneNumber) {
            if (! in_array($phoneNumber->number, $request->number)) {
                $phoneNumber->delete();
            }
        }
        foreach ($request->number as $number) {
            $alreadyAssigned = $contact->phoneNumbers->firstWhere('number', $number);
            if (
                empty($alreadyAssigned)
                && ! empty($number)
            ) {
                PhoneNumber::create(['number' => $number, 'contact_id' => $contact->id]);
            }
        }
        $contact->save();

        return redirect()->route('contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact): Response
    {
        $contact->delete();

        return redirect()->route('contacts.index');
    }
}
