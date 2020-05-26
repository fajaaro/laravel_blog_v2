@extends('layouts.app')

@section('content')
    <div class="container">

    @if (session('verified') || session('status') || session('loginSuccess'))
        <div class="row mb-5">
            <div class="col-8">
                <div class="card">
                       
                    @if (session('verified'))
                        <ul class="list-group mb-3">
                            <li class="list-group-item bg-success text-white"><i class="fas fa-check mr-2"></i>Register Success!</li>
                            <li class="list-group-item text-dark">Thank you for register and verifying your email address.</li>
                        </ul>
                    @endif

                    @if (session('status'))
                        <ul class="list-group mb-3">
                            <li class="list-group-item active bg-success"><i class="fas fa-check mr-2"></i>Reset Password Success!</li>
                            <li class="list-group-item">{{ session()->get('status') }}</li>
                        </ul>
                    @endif

                    @if (session('loginSuccess'))
                        {{ session()->get('loginSuccess') }}
                    @endif

            </div>
        </div>
    @endif

    @forelse ($posts as $post)
        <div class="row mb-3">
            <div class="col-8">
                <div class="card card-post">
                    <div class="card-header">
                        <span>{{ $post->user->name }}'s Post</span>
                        <span class="float-right">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
        
                    <div class="card-body">
                        <h4 class="font-weight-bold"><a href="{{ route('post.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h4>
                        <p>{{ $post->content }}</p>                
                    </div>

                    <div class="row">
                        <div class="col-1 mr-4">
                            @can('delete', $post)
                                <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="post" class="user-action">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            @endcan                            
                        </div>
                        <div class="col-1">
                            @can('update', $post)
                                <a href="{{ route('post.edit', ['post' => $post->id]) }}"><button class="btn btn-primary user-action">Update</button></a>
                            @endcan                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @empty

    @endforelse

        
    </div>
@endsection
