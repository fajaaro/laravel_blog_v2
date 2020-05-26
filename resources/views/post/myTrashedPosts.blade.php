@extends('layouts.app')

@section('right-sidebar')
    <div class="row index-box">
        
        <div class="col-9 posts-box">
            @foreach ($posts as $post)
                <div class="card card-post mb-4">
                    <div class="card-header">
                        <small>{{ Cache::get('userActive')->name }}'s Post</small>
                        <small class="float-right">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
        
                    <div class="card-body">
                        <h5 class="font-weight-bold"><a href="{{ route('post.show', ['post' => $post->id]) }}" class="text-dark">{{ $post->title }}</a></h5>
                        <p class="post-content">{{ $post->content }}</p>                
                    </div>

                    <div class="row mt-2">
                        <div class="col-1 mr-2">
                            <button class="btn btn-info user-action btn-action btn-restore" id="{{ $post->id }}">Restore</button>
                        </div>
                        <div class="col-3">
                            <button data-href="{{ URL::to('/post/' . $post->id . '/force-delete') }}" class="btn btn-info user-action btn-action force-delete-button">Permanent Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach                    
        </div>
        
        <div class="col-3">
            @include('layouts.mau')
            <br>            
            @include('layouts.mcp')
        </div>

    </div>

@endsection
