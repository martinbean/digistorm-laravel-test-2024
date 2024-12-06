@extends('layouts.app')

@section('title', __('Contacts'))

@section('content')
    <div class="flex flex-col">
        <x-page-header>
            <x-slot:title>{{ __('Contacts') }}</x-slot:title>
            <x-slot:actions>
                <a href="{{ route('contacts.create') }}" class="btn btn-primary">{{ __('Add contact') }}</a>
            </x-slot:actions>
        </x-page-header>
        <ul class="gap-4 grid grid-cols-4">
            @foreach($contacts as $contact)
                <li>
                    <div class="bg-white flex flex-col h-full rounded shadow">
                        <div class="flex flex-col grow p-4">
                            <div class="grow">
                                <div class="mb-2">
                                    <h2 class="m-0">
                                        <a class="font-medium" href="{{ route('contacts.show', compact('contact')) }}">{{ $contact->full_name }}</a>
                                    </h2>
                                    <p class="m-0 text-sm">{{ $contact->company_name }} &ndash; {{ $contact->position }}</p>
                                </div>
                                <p class="mb-3 text-sm">
                                    @if(isset($contact->email))
                                        <span class="block">{{ $contact->email }}</span>
                                    @endif
                                    @foreach($contact->phoneNumbers as $phoneNumber)
                                        <span class="block">{{ $phoneNumber->number }}</span>
                                    @endforeach
                                </p>
                            </div>
                            <ul class="flex gap-3 m-0 text-sm">
                                <li class="inline-flex">
                                    <a class="font-medium text-sky-500 hover:text-sky-600 hover:underline" href="{{ route('contacts.edit', compact('contact')) }}" class="btn btn-info">Edit</a>
                                </li>
                                <li class="inline-flex">
                                    <form action="{{ route('contacts.destroy', compact('contact')) }}" class="inline-block" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-700 hover:underline">Delete</a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        @if($contacts->hasPages())
            <div class="mt-4 row">
                {{ $contacts->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
