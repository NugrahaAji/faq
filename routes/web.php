<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\SubTopicController;
use App\Http\Controllers\Admin\FaqController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Topics
    Route::resource('topics', TopicController::class);

    // Sub Topics
    Route::resource('subtopics', SubTopicController::class);
    Route::get('api/subtopics/topic/{topicId}', [SubTopicController::class, 'getByTopic'])
        ->name('api.subtopics.by-topic');

    // FAQs
    Route::resource('faqs', FaqController::class);
});

// Redirect root admin ke FAQs
Route::get('/admin', function () {
    return redirect()->route('admin.faqs.index');
});
