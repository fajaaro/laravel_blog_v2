@extends('layouts.app')

@section('right-sidebar')
	<x-card-post>
		@slot('cardHeader')
			Create Post
		@endslot

		<form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="inputTitle">Title</label>
				<input type="text" class="form-control" name="title" id="inputTitle" placeholder="Enter title" value="{{ old('title') }}">
			</div>
			<div class="form-group">
				<label for="inputContent">Content</label>
				<textarea class="form-control" name="content" id="inputContent" placeholder="Enter content" rows="4">{{ old('content') }}</textarea>
			</div>
			<div class="form-group">
				<label for="inputFile">Thumbnail</label>
				<input type="file" name="thumbnail" class="form-control-file">
			</div>
			<button type="submit" class="btn btn-block btn-info">Create</button>
		</form>	
	</x-card-post>
@endsection

