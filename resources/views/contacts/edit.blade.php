@extends('layouts.app')

@section('content')
    <x-page-header>
        <x-slot:title>{{ __('Edit contact') }}</x-slot:title>
    </x-page-header>

    <x-form-errors />

    <form method="POST" action="{{ route('contacts.update', ['contact' => $contact]) }}">
        @csrf
        @method('put')
        <x-form-group>
            <x-slot:label for="first_name">{{ __('First name') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" id="first_name" maxlength="50" name="first_name" required type="text" value="{{ old('first_name', $contact->first_name) }}"/>
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="last_name">{{ __('Last name') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" maxlength="50" name="last_name" required type="text" value="{{ old('last_name', $contact->last_name) }}"/>
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="DOB">{{ __('Date of birth') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" max="{{ date('Y-m-d') }}" name="DOB" type="date" value="{{ old('DOB', $contact->DOB) }}"/>
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="company_name">{{ __('Company') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" name="company_name" required type="text" value="{{ old('company_name', $contact->company_name) }}"/>
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="position">{{ __('Position') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" name="position" required type="text" value="{{ old('position', $contact->position) }}"/>
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="email">{{ __('Email') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" name="email" type="text" value="{{ old('email', $contact->email) }}">
            </x-slot:input>
        </x-form-group>
        <x-phone-numbers-input :value="old('number', $contact->phoneNumbers->pluck('number')->toArray())" />
        <div>
            <button class="btn btn-primary" type="submit">{{ __('Update contact') }}</button>
        </div>
    </form>
@endsection
