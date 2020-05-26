<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\PostPosted;
use App\Image;
use App\Jobs\SendEmailAfterComment;
use App\Mail\CommentPosted;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // data dari file post.index didapat dari ActivityComposer yang sudah didaftarkan di ViewServiceProvider
        return view('post.index');
    }

    public function create()
    {
        $this->authorize('create', Post::class);
     
        return view('post.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $user = Auth::user();

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;

        $user->posts()->save($post);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');

            $path = $file->storeAs('thumbnails', $post->id . '.' . $file->guessExtension());

            $post->image()->save(
                Image::create([
                    'path' => $path,
                    'imageable_id' => $post->id,
                    'imageable_type' => 'Post'
                ])
            );
        }

        $posts = Post::with(['user', 'image'])->orderBy('created_at', 'desc')->get();

        Cache::forget('posts');

        event(new PostPosted($post));

        return redirect()->route('home');
    }

    public function show($id)
    {
        $post = Cache::remember("post-{$id}", now()->addMinutes(2), function() use($id) {
            return Post::with(['comments.user', 'user', 'image'])->findOrFail($id);
        });

        return view('post.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        return view('post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        Cache::forget("post-{$id}");

        return redirect()->route('post.show', ['post' => $id]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('delete', $post);

        $post->delete();

        $posts = Post::with(['user', 'image'])->orderBy('created_at', 'desc')->get();

        Cache::forget('posts');
        Cache::forget('mostCommentedPosts');
        Cache::forget('mostActiveUsers');

        return response()->json(['destroySuccess' => 'Delete success!']);
    }

    public function myPosts()
    {
        if (!Gate::allows('view', Post::class)) return redirect()->route('home');

        // data dari file post.index didapat dari ActivityComposer yang sudah didaftarkan di ViewServiceProvider        
        return view('post.myPosts');

    }

    public function myTrashedPosts()
    {
        if (!Gate::allows('view', Post::class)) return redirect()->route('home');

        $posts = Post::onlyTrashed()->where('user_id', Cache::get('userActive')->id)->descOrderedPosts()->get();

        return view('post.myTrashedPosts', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $post);
        
        $post->restore();

        Cache::forget('posts');
        Cache::put('posts', $posts, now()->addMinutes(1));

        return response()->json(['restoreSuccess' => 'Restore success!']);
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $post);

        $post->forceDelete();

        return redirect()->route('post.myPosts');
    }

    public function addComment(Request $request)
    {
        $this->authorize('addComment', Post::class);

        $comment = new Comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = $request->user_id;
        $comment->content = $request->content;
        $comment->save();

        $id = $comment->post_id;

        Cache::forget("post-{$id}");

        SendEmailAfterComment::dispatch($request->user(), $comment);

        return back();
    }
}
