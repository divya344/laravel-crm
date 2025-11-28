<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskFileController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskTimeController;
use App\Http\Controllers\TaskLabelController;
use App\Http\Controllers\TaskWatcherController;
use App\Http\Controllers\TaskReminderController;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard');

/*
|--------------------------------------------------------------------------
| Authentication Routes (No middleware)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Requires Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Task Module MUST START with KANBAN routes (to avoid conflict)
    |--------------------------------------------------------------------------
    */

    // Kanban FIRST
    Route::get('/tasks/kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
    Route::post('/tasks/kanban/update', [TaskController::class, 'kanbanUpdate'])->name('tasks.kanban.update');

    // Then resource route
    Route::resource('tasks', TaskController::class);

    /*
    |--------------------------------------------------------------------------
    | Task Extras: Comments, Files, Subtasks, Labels, Watchers, Reminders
    |--------------------------------------------------------------------------
    */

    // Comments
    Route::post('/tasks/{id}/comments', [TaskCommentController::class, 'store'])
        ->name('tasks.comments.store');

    // Files
    Route::post('/tasks/{id}/files', [TaskFileController::class, 'store'])
        ->name('tasks.files.store');

    // Subtasks
    Route::post('/tasks/{id}/subtasks', [SubtaskController::class, 'store'])
        ->name('tasks.subtasks.store');

    Route::post('/subtasks/{id}/toggle', [SubtaskController::class, 'toggle'])
        ->name('subtasks.toggle');

    // Time tracking
    Route::post('/tasks/{id}/timer/start', [TaskTimeController::class, 'start'])
        ->name('tasks.timer.start');

    Route::post('/tasks/{id}/timer/stop', [TaskTimeController::class, 'stop'])
        ->name('tasks.timer.stop');

    // Labels
    Route::post('/tasks/{id}/labels', [TaskLabelController::class, 'attach'])
        ->name('tasks.labels.attach');

    Route::delete('/tasks/{id}/labels/{label_id}', [TaskLabelController::class, 'detach'])
        ->name('tasks.labels.detach');

    // Watchers
    Route::post('/tasks/{id}/watch', [TaskWatcherController::class, 'watch'])
        ->name('tasks.watch');

    Route::delete('/tasks/{id}/unwatch', [TaskWatcherController::class, 'unwatch'])
        ->name('tasks.unwatch');

    // Reminders
    Route::post('/tasks/{id}/reminder', [TaskReminderController::class, 'store'])
        ->name('tasks.reminder.store');


    /*
    |--------------------------------------------------------------------------
    | CRM Modules
    |--------------------------------------------------------------------------
    */
    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);

    Route::resource('invoices', InvoiceController::class);
    Route::resource('estimates', EstimateController::class);
    Route::resource('leads', LeadController::class);
    Route::resource('contracts', ContractController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('payments', PaymentController::class);

    /*
    |--------------------------------------------------------------------------
    | Chat
    |--------------------------------------------------------------------------
    */
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/messages', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/messages', [ChatController::class, 'fetch'])->name('chat.fetch');

    /*
    |--------------------------------------------------------------------------
    | File Manager
    |--------------------------------------------------------------------------
    */
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    /*
    |--------------------------------------------------------------------------
    | Profile Settings
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});
