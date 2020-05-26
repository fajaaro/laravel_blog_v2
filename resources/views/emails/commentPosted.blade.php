<style type="text/css">
	body {
		font-family: Arial, Helvetica, sans-serif;
	}
</style>

<p>Ada comment baru di post anda yang berjudul <a href="{{ route('post.show', ['post' => $comment->post->id]) }}">{{ $comment->post->title }}</a></p>
<hr>
<p>Isi Comment: </p>
<p>{{ $comment->content }}</p>
<hr>
<p>Comment ditulis oleh {{ $comment->user->name }}</p>
<p>Link: {{ $comment->user->image()->exists() ? $comment->user->image->url() : asset('img/avatar.svg') }}</p>
<img src="{{ $message->embed(public_path('storage\avatars\1.jpeg')) }}" style="		width: 100px; height: 100px; border: 3px solid black; padding: 4px;">