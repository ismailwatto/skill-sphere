@extends('layouts.standalone')

@section('title', 'CRUD Operations Module')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-11 col-xl-10 mx-auto">
            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Documentation
                </a>
            </div>

            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box bg-info-soft me-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-layers-half text-info" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-1">CRUD Operations - Complete Implementation</h1>
                        <p class="text-muted mb-0">Create, Read, Update, and Delete logic with Laravel Resource Controllers</p>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-success-soft text-success px-3 py-2">Laravel 11</span>
                    <span class="badge bg-primary-soft text-primary px-3 py-2">Resource Controllers</span>
                    <span class="badge bg-info-soft text-info px-3 py-2">Eloquent ORM</span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">📋 Table of Contents</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step1">1. Model & Migration</a></li>
                                <li class="mb-2"><a href="#step2">2. Resource Controller</a></li>
                                <li class="mb-2"><a href="#step3">3. Form Request Validation</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step4">4. Resource Routes</a></li>
                                <li class="mb-2"><a href="#step5">5. Blade Views (List & Create)</a></li>
                                <li class="mb-2"><a href="#step6">6. Success Messages</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 1 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step1">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 1</span>
                        Model & Migration
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">1.1 Generate Model with Migration</h5>
                    <pre class="code-block"><code>php artisan make:model Post -m</code></pre>

                    <p class="text-muted mb-2 mt-4"><strong>File:</strong> <code>database/migrations/xxxx_xx_xx_create_posts_table.php</code></p>
<pre class="code-block"><code>&lt;?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('posts', function (Blueprint $table) {
            $table-&gt;id();
            $table-&gt;string('title');
            $table-&gt;text('content');
            $table-&gt;timestamps();
        });
    }
};</code></pre>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step2">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 2</span>
                        Resource Controller
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">2.1 Generate Resource Controller</h5>
                    <pre class="code-block"><code>php artisan make:controller PostController --resource</code></pre>

                    <p class="text-muted mb-2 mt-4"><strong>File:</strong> <code>app/Http/Controllers/PostController.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller {
    public function index() {
        $posts = Post::latest()-&gt;get();
        return view('posts.index', compact('posts'));
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $validated = $request-&gt;validate([
            'title' =&gt; 'required|max:255',
            'content' =&gt; 'required',
        ]);

        Post::create($validated);
        return redirect()-&gt;route('posts.index')-&gt;with('success', 'Post created!');
    }

    public function edit(Post $post) {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post) {
        $validated = $request-&gt;validate([
            'title' =&gt; 'required|max:255',
            'content' =&gt; 'required',
        ]);

        $post-&gt;update($validated);
        return redirect()-&gt;route('posts.index')-&gt;with('success', 'Post updated!');
    }

    public function destroy(Post $post) {
        $post-&gt;delete();
        return redirect()-&gt;route('posts.index')-&gt;with('success', 'Post deleted!');
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step3">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 3</span>
                        Form Request Validation
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">3.1 Create Request Class</h5>
                    <pre class="code-block"><code>php artisan make:request StorePostRequest</code></pre>

                    <p class="text-muted mb-2 mt-4"><strong>File:</strong> <code>app/Http/Requests/StorePostRequest.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'title' =&gt; 'required|string|max:255',
            'content' =&gt; 'required|string',
        ];
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 4</span>
                        Resource Routes
                    </h3>
                    
                    <p class="text-muted mb-2"><strong>File:</strong> <code>routes/web.php</code></p>
<pre class="code-block"><code>use App\Http\Controllers\PostController;

Route::resource('posts', PostController::class);</code></pre>
                </div>
            </div>

            <!-- STEP 5 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step5">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 5</span>
                        Blade Views (Index)
                    </h3>
                    
                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/views/posts/index.blade.php</code></p>
<pre class="code-block"><code>@@extends('layouts.app')

@@section('content')
&lt;div class="container"&gt;
    &lt;div class="d-flex justify-content-between mb-4"&gt;
        &lt;h2&gt;Posts&lt;/h2&gt;
        &lt;a href="@{{ route('posts.create') }}" class="btn btn-primary"&gt;New Post&lt;/a&gt;
    &lt;/div&gt;

    &lt;table class="table"&gt;
        &lt;thead&gt;
            &lt;tr&gt;
                &lt;th&gt;Title&lt;/th&gt;
                &lt;th&gt;Actions&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
            @@foreach($posts as $post)
            &lt;tr&gt;
                &lt;td&gt;@{{ $post-&gt;title }}&lt;/td&gt;
                &lt;td&gt;
                    &lt;a href="@{{ route('posts.edit', $post) }}" class="btn btn-sm btn-info"&gt;Edit&lt;/a&gt;
                    &lt;form action="@{{ route('posts.destroy', $post) }}" method="POST" class="d-inline"&gt;
                        @@csrf @@method('DELETE')
                        &lt;button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"&gt;Delete&lt;/button&gt;
                    &lt;/form&gt;
                &lt;/td&gt;
            &lt;/tr&gt;
            @@endforeach
        &lt;/tbody&gt;
    &lt;/table&gt;
&lt;/div&gt;
@@endsection</code></pre>
                </div>
            </div>

            <!-- STEP 6 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step6">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 6</span>
                        Success Messages
                    </h3>
                    
                    <p class="text-muted mb-2">Add this to your main layout (e.g., <code>app.blade.php</code>):</p>
<pre class="code-block"><code>@@if(session('success'))
    &lt;div class="alert alert-success alert-dismissible fade show" role="alert"&gt;
        @{{ session('success') }}
        &lt;button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"&gt;&lt;/button&gt;
    &lt;/div&gt;
@@endif</code></pre>
                </div>
            </div>

            <!-- Summary -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-success-soft">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4 text-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Summary
                    </h3>
                    <ul class="mb-0">
                        <li>✅ Eloquent Model & Schema Migration</li>
                        <li>✅ Resourceful Controller with standard methods</li>
                        <li>✅ Route::resource for clean URL architecture</li>
                        <li>✅ Blade Views with Bootstrap 5 integration</li>
                        <li>✅ Form Validation & Flash Messages</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-5 mb-5">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-arrow-left me-2"></i>Back to Documentation Home
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.code-block {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 1.25rem;
    border-radius: 8px;
    overflow-x: auto;
    font-family: 'Fira Code', 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 0;
}

.code-block code {
    background: transparent;
    color: #d4d4d4;
    padding: 0;
}
</style>
@endsection
