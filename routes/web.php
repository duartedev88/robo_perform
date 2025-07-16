<?php

use App\Http\Controllers\Admin\ScheduledPostController;
use App\Http\Controllers\Admin\IntegrationStatusController;
use Illuminate\Support\Facades\Route;

Route::view('/privacidade', 'legal.privacidade')->name('privacidade');
Route::view('/excluir-dados', 'legal.excluir-dados')->name('excluir-dados');
Route::view('/termos', 'legal.termos')->name('termos');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('scheduled-posts', ScheduledPostController::class);
    Route::post('scheduled-posts/{scheduledPost}/post-now', [ScheduledPostController::class, 'postNow'])->name('scheduled-posts.post-now');
    Route::get('admin/integration-status', [IntegrationStatusController::class, 'index'])->name('admin.integration-status');
});
