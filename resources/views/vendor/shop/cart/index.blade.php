@extends('layouts.other')
@section('content')
    <div class="vue_app">
        <cart-component :products="{{ $products->toJson() }}"
                        privacy-policy-link="{{ route('page.show', settings('policy_page', default: 1)) }}"></cart-component>
    </div>
@endsection
