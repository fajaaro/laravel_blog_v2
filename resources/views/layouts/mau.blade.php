<ul class="list-group">
	<li class="list-group-item bg-dark text-white"><small>Most Active Users</small></li>
	@foreach ($data['mostActiveUsers'] as $user)
		<li class="list-mcp list-group-item">{{ $user->name }} ({{ $user->posts_count }} Posts and {{ $user->comments_count }} Comments)</li>
	@endforeach
</ul>
