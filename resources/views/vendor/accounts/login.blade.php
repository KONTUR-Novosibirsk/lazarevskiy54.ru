@extends('layouts.other2')
@section('content')
    <div class="personal-page">
        <div class="container">
            <div class="vue_app">
                <login-form-component :is-modal="false"
                    privacy-policy-link="{{ route('page.show', settings('policy_page', default: 1)) }}"
                ></login-form-component>
            </div>
        </div>
    </div>
@endsection
