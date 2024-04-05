@extends('client.layouts.app')

@section('content')
    @if ($order->payment_status == 'OK')
        <h2 class="alert alert-success text-center">پرداخت با موفقیت انجام شد</h2>
    @else
        <h2 class="alert alert-danger text-center">پرداخت ناموفق بود</h2>
    @endif
@endsection
