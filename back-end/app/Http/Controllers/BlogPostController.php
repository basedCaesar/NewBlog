<?php
namespace App\Http\Controllers;

use App\Interfaces\BlogPostServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    protected $blogPostService;

    public function __construct(BlogPostServiceInterface $blogPostService)
    {
        $this->blogPostService = $blogPostService;
    }

    public function index()
    {
        $blogPosts = $this->blogPostService->getAllPosts();
        return response()->json($blogPosts);
    }

    public function store(StoreBlogPostRequest $request)
    {
        $blogPost = $this->blogPostService->createPost($request->validated(), Auth::id());
        return response()->json($blogPost, 201);
    }

    public function show($id)
    {
        $blogPost = $this->blogPostService->getPostById($id);
        return response()->json($blogPost);
    }

    public function update(UpdateBlogPostRequest $request, $id)
    {
        $blogPost = $this->blogPostService->updatePost($id, $request->validated(), Auth::id());
        return response()->json($blogPost, 200);
    }

    public function destroy($id)
    {
        $this->blogPostService->deletePost($id, Auth::id());
        return response()->json(null, 204);
    }
}
