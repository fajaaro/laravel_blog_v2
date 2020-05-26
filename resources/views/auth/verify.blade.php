@extends('layouts.app')

@section('right-sidebar')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body card-verif-email">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline form-request-another-verif" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-dark">{{ __('click here to request another') }}.</button>
                        <img src="{{ asset('gif/25.gif') }}" width="20" class="loading-gif">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


