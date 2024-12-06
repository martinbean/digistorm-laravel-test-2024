@extends('layouts.app')

@section('content')
    <x-page-header>
        <x-slot:title>{{ $contact->full_name }}</x-slot:title>
        <x-slot:actions>
            <a class="btn btn-primary" href="{{ route('contacts.edit', ['contact' => $contact]) }}" class="btn btn-info">{{ __('Edit') }}</a>
            <form action="{{ route('contacts.destroy', ['contact' => $contact]) }}" class="inline-block" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger" type="submit">{{ __('Delete') }}</a>
            </form>
        </x-slot:actions>
    </x-page-header>
    <section class="mb-4" id="details">
        <h2 class="font-bold mb-2 text-base">{{ __('Details') }}</h2>
        <div class="bg-white flex flex-col h-full rounded shadow">
            <div class="flex flex-col gap-1 p-4">
                <h3 class="font-medium">
                    <span>{{ $contact->company_name }}</span>
                    <span aria-hidden="true">&ndash;</span>
                    <span>{{ $contact->position }}</span>
                </h3>
                @if(isset($contact->email))
                    <p>{{ $contact->email }}</p>
                @endif
            </div>
        </div>
    </section>
    <section id="phone-numbers">
        <h2 class="font-bold mb-2 text-base">{{ $contact->phoneNumbers->count() === 1 ? __('Phone number') : __('Phone numbers') }}</h2>
        <div class="bg-white flex flex-col h-full rounded shadow">
            <div class="flex flex-col grow p-4">
                <p>
                    @foreach($contact->phoneNumbers as $phoneNumber)
                        <span class="block">{{ $phoneNumber->number }}</span>
                    @endforeach
                </p>
            </div>
        </div>
    </section>
@endsection
