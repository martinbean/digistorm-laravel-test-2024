@extends('layouts.app')

@section('content')
    <x-page-header>
        <x-slot:title>{{ __('Add contact') }}</x-slot:title>
    </x-page-header>

    <x-form-errors />

    <form method="POST" action="{{ route('contacts.store') }}">
        @csrf
        <x-form-group>
            <x-slot:label for="first_name">{{ __('First name') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" id="first_name" maxlength="50" name="first_name" required type="text" value="{{ old('first_name') }}">
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="last_name">{{ __('Last name') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" maxlength="50" name="last_name" required type="text" value="{{ old('last_name') }}">
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="DOB">{{ __('Date of birth') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" max="{{ date('Y-m-d') }}" name="DOB" required type="date" value="{{ old('DOB') }}">
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="company_name">{{ __('Company') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" maxlength="100" name="company_name" required type="text" value="{{ old('company_name') }}">
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="position">{{ __('Position') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" maxlength="100" name="position" required type="text" value="{{ old('position') }}">
            </x-slot:input>
        </x-form-group>
        <x-form-group>
            <x-slot:label for="email">{{ __('Email') }}</x-slot:label>
            <x-slot:input>
                <input class="form-control" maxlength="255" name="email" type="text" value="{{ old('email') }}">
            </x-slot:input>
        </x-form-group>
        <x-phone-numbers-input :value="old('number', [])" />
        <div>
            <button type="submit" class="btn btn-primary">{{ __('Add contact') }}</button>
        </div>
    </form>
@endsection
