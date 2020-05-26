@extends('layouts.app')

@section('right-sidebar')
    <div class="row index-box">
        
        <div class="col-9 posts-box">
            @forelse ($data['posts'] as $post)
                <div class="card card-post mb-4">
                    <div class="card-header">
                        <small>{{ $post->user->name }}'s Post</small>
                        <small class="float-right">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
        
                    <div class="card-body">
                        <h5 class="font-weight-bold"><a href="{{ route('post.show', ['post' => $post->id]) }}" class="text-dark">{{ $post->title }}</a></h5>
                        <p class="post-content">{{ $post->content }}</p>                
                    </div>
                </div>
            @empty

            @endforelse                    
        </div>
        
        <div class="col-3">
            @include('layouts.mau')            
            <br>
            @include('layouts.mcp')
        </div>

    </div>

@endsection
