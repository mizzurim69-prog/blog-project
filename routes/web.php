<?php

use Illuminate\Support\Facades\Route;
use App\Models\Blog;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});    


Route::redirect('/create', '/blogs/create'); // compatibility redirect: old /create -> /blogs/create

Route::inertia('/blogs/create', 'BlogCreate')->name('blogs.create');
Route::post('/blogs/store', function () {
    request()->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    
    $blog = new Blog();
    $blog->title = request('title');
    $blog->description = request('content');
    $blog->save();
    return redirect('/blogs');

})->name('blogs.store');

Route::get('/blogs/{blog}', function (Blog $blog) {

    return inertia('BlogShow', [
        'blog' => $blog
    ]);

})->name('blogs.show');

Route::get('/blogs', function () {
        
    return inertia('Blogs', [
            'blogs' => Blog::latest()->get()
        ]);
     })->name('blogs');

Route::get('/blogs/{blog}/edit', function (App\Models\Blog $blog) {
    return inertia('BlogEdit', [
        'blog' => $blog
    ]);
})->name('blogs.edit');

Route::put('/blogs/{blog}', function (App\Models\Blog $blog) {
    // log incoming payload for debugging
    logger()->info('blogs.update called', request()->all());

    $data = request()->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $blog->update([
        'title' => $data['title'],
        'description' => $data['content'],
    ]);

    // After updating, redirect back to the blogs index
    return redirect()->route('blogs');

})->name('blogs.update');

// Delete a blog
Route::delete('/blogs/{blog}', function (App\Models\Blog $blog) {
    $blog->delete();
    return redirect()->route('blogs');
})->name('blogs.destroy');

require __DIR__.'/settings.php';
