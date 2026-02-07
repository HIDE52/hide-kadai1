@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks__back">
        Thank you
    </div>

    <div class="thanks__message">
        <div class="thanks__heading">
            <h2>お問い合わせありがとうございました</h2>
        </div>
        <div class="thanks__button">
            <a class="thanks__button-link" href="/">HOME</a>
        </div>
    </div>
</div>
@endsection