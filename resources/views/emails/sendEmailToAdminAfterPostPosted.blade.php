@component('mail::message')
# {{ $post->user->name }} Added a Post To Your Blog

@component('mail::button', ['url' => route('post.show', ['post' => $post->id])])
Go To Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
