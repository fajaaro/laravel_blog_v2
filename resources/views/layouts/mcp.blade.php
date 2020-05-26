<ul class="list-group">
	<li class="list-group-item bg-dark text-white"><small>Most Commented Posts</small></li>
	@foreach ($data['mostCommentedPosts'] as $post)
		<li class="list-group-item d-flex justify-content-between align-items-center">
			<a href="{{ route('post.show', ['post' => $post->id]) }}" class="text-dark"><small>{{ $post->title }}</small></a> 
			<span class="badge badge-info badge-pill">{{ $post->comments_count }}</span>
		</li>
	@endforeach
</ul>
