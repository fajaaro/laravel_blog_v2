@extends('layouts.app')

@section('right-sidebar')
    <div class="row index-box">
        
        <div class="col-9 posts-box">
            @foreach ($data['posts'] as $post)
                @if ($post->user_id == Cache::get('userActive')->id)
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
                                <a href="{{ route('post.edit', ['post' => $post->id]) }}"><button class="btn btn-info user-action btn-action">Update</button></a>
                            </div>
                            <div class="col-1">
                                <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="post" class="user-action">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-info btn-action btn-delete" id="{{ $post->id }}">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach                    
        </div>
        
        <div class="col-3">
            @include('layouts.mau')
            <br>            
            @include('layouts.mcp')
        </div>

    </div>

@endsection
