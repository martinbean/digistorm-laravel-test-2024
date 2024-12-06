@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Edit Contact</h1>
        </div>

        <x-form-errors />

        <form method="POST" action="{{ route('contacts.update', ['contact' => $contact]) }}">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-auto">
                    <label class="form-label">First Name
                        <input type="text" name="first_name" value="{{ old('first_name', $contact->first_name) }}"/>
                    </label>
                </div>
            </div>
            <div class="row">
                <label class="form-label">Last Name
                    <input type="text" name="last_name" value="{{ old('last_name', $contact->last_name) }}"/>
                </label>
            </div>
            <div class="row">
                <div class="col-auto">
                    <label class="form-label">Date of Birth
                        <input type="text" name="DOB" value="{{ old('DOB', $contact->DOB) }}"/>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <label class="form-label">Company
                        <input type="text" name="company_name" value="{{ old('company_name', $contact->company_name) }}"/>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <label class="form-label">Position
                        <input type="text" name="position" value="{{ old('position', $contact->position) }}"/>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <label class="form-label">Email
                        <input type="text" name="email" value="{{ old('email', $contact->email) }}"/>
                    </label>
                </div>
            </div>
            <x-phone-numbers-input :value="old('number', $contact->phoneNumbers->pluck('number')->toArray())" />
            <div class="row">
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
           </div>
        </form>
    </div>
@endsection
