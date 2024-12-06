@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h1>Add Contact</h1>
        </div>

        <x-form-errors />

        <form method="POST" action="{{ route('contacts.store') }}">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-label">First Name
                            <input maxlength="50" name="first_name" required type="text" value="{{ old('first_name') }}">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <label class="form-label">Last Name
                            <input maxlength="50" name="last_name" required type="text" value="{{ old('last_name') }}">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <label class="form-label">Date of Birth
                            <input name="DOB" required type="date" value="{{ old('DOB') }}">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <label class="form-label">Company
                            <input maxlength="100" name="company_name" required type="text" value="{{ old('company_name') }}">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <label class="form-label">Position
                            <input maxlength="100" name="position" required type="text" value="{{ old('position') }}">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <label class="form-label">Email
                            <input maxlength="255" name="email" type="text">
                        </label>
                    </div>
                </div>
                <x-phone-numbers-input :value="old('number', [])" />
            </div>
        </form>
    </div>
@endsection
