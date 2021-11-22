<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function create()
    {
        return Inertia::render('Instagram/CreatePostForm');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        //모든 이미지를 1200 x 1200으로 만든다. 그것보다 크면 자른다.
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([ //로그인한 사용자의 id로 포스트를 생성
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return Redirect::route('dashboard');
    }
}
