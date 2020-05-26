@extends('layouts.app')

@section('right-sidebar')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-register pb-3">
                <div class="card-header">{{ __('My Profile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="form-group row">
                            <label for="avatar" class="col-md-3 col-form-label text-md-right">Avatar</label>
                            
                            @if ($user->image)
                                <img src="{{ 'http://localhost:8000/storage/' . $user->image->path }}" class="avatar" for="avatar">
                                <input type="file" name="avatar" class="form-control-file">
                            @else
                                <div class="col-md-9">
                                    <input type="file" name="avatar" class="form-control-file">
                                </div>                            
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new-password" class="col-md-3 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="new-password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new-password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-9">
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password-confirm" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-info">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

