<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class MainController extends Controller
{
    public function index(): Response{
        $posts = Post::all();
        return Inertia::render('Dashboard', [
            'posts' => PostResource::collection($posts)
        ]);
    }
}
