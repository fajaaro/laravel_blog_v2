@extends('layouts.app')

@section('right-sidebar')
    <div class="row mb-4">
        <div class="col-10">
            <div class="card card-post">
                <div class="card-header">
                    <small>{{ $post->user->name }}'s Post</small>
                    <small class="float-right">{{ $post->created_at->diffForHumans() }}</small>
                </div>
    
                <div class="card-body">
                    @if ($post->image)
                        <img src="{{ 'http://localhost:8000/storage/' . $post->image->path }}" class="post-thumbnail">
                    @endif

                    <h5 class="font-weight-bold"><a href="{{ route('post.show', ['post' => $post->id]) }}" class="text-dark">{{ $post->title }}</a></h5>
                    <p class="post-content">{{ $post->content }}</p>                
                </div>

                <div class="row mt-2">
                    <div class="col-1">
                        @can('update', $post)
                            <a href="{{ route('post.edit', ['post' => $post->id]) }}"><button class="btn btn-info user-action btn-action">Update</button></a>
                        @endcan                            
                    </div>
                    <div class="col-1">
                        @can('delete', $post)
                            <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="post" class="user-action">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-info btn-action">Delete</button>
                            </form>
                        @endcan                            
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-10">
            <div class="card card-post">
                <div class="card-header">
                    <small>Comments ({{ count($post->comments) }})</small>
                </div>

                <div class="list-group">
                    @forelse ($post->comments as $comment)
                        <div class="row">
                            <div class="col-12 mt-3 d-flex">
                                <div class="col-1">
                                    <img src="{{ url('img/joker.jpg') }}" class="rounded-0 profile-commentator">
                                </div>
                                <div class="col-11 pb-3">
                                    <p class="comment-content mb-3">{{ $comment->content }}</p>
                                    
                                    <small class="text-secondary comment-info">
                                        <span>by {{ $comment->user->name }} on </span> 
                                        <span class="comment-time">{{ $comment->created_at->isoFormat('dddd D, Y') }}</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @empty 
                        <li class="list-group-item d-flex flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <small class="mb-1">Empty.</small>
                            </div>
                        </li>                        
                    @endforelse

                </div>  
                
                @if (Cache::has('userActive'))
                    <div class="card-footer bg-white">
                        <button type="button" class="btn btn-info btn-action" data-toggle="modal" data-target="#modalComment">Add Comment</button>     
                    </div>                  
                @endif
            </div>
        </div>

        <div class="col-10 mt-4">
            
        </div>
    </div>

    @if (Auth::check())
        <div class="modal fade" id="modalComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Add Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('post.addComment') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <textarea class="form-control" name="content" id="inputComment" rows="3" placeholder="Write your comment...">{{ old('content') }}</textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-action" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-action">Submit</button>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
