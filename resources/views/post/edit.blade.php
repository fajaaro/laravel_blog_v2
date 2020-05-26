@extends('layouts.app')

@section('right-sidebar')
	<x-card-post>
		@slot('cardHeader')
			Edit Post
		@endslot

		<form method="post" action="{{ route('post.update', ['post' => $post->id]) }}">
			@csrf
			@method('put')
			<div class="form-group">
				<label for="inputTitle">Title</label>
				<input type="text" class="form-control" name="title" id="inputTitle" placeholder="Enter title" value="{{ old('title', $post->title) }}">
			</div>
			<div class="form-group">
				<label for="inputContent">Content</label>
				<textarea class="form-control" name="content" id="inputContent" placeholder="Enter content" rows="4">{{ old('content', $post->content) }}</textarea>
			</div>
			<button type="submit" class="btn btn-block btn-info">Update</button>
		</form>			
	</x-card-post>
@endsection