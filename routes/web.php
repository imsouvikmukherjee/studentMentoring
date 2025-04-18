<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\MentoringController;
use App\Http\Controllers\Admin\AcademicDetailsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    if (Auth::check()) {
        $usertype = Auth::user()->usertype;
        if ($usertype === 'Student') {
            return redirect()->route('user.dashboard');
        } elseif (in_array($usertype, ['Admin', 'Mentor', 'Superadmin'])) {
            return redirect()->route('admin_dashboard');
        }
    }
    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/', [AuthenticatedSessionController::class, 'create'])
// ->middleware(['auth', 'verified'])->name('login');

Route::middleware('auth','isAdmin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/student/dashboard',[DashboardController::class,'userDashboard'])->name('user.dashboard');
    Route::get('/student/edit-profile',[DashboardController::class,'editProfile'])->name('user.edit.profile');
    Route::post('/student/update-profile',[DashboardController::class,'updateProfile'])->name('user.update.profile');
    Route::get('/student/change-requests',[DashboardController::class,'showChangeRequests'])->name('user.change.requests');
    Route::get('/student/mentoring',[DashboardController::class,'mentoring'])->name('user.mentoring');
    Route::post('/student/mentoring/update',[DashboardController::class,'updateMentoringData'])->name('user.mentoring.update');

    // Mentoring Routes
    Route::get('/mentoring/edit', [MentoringController::class, 'edit'])
        ->name('user.mentoring.edit');
    Route::post('/mentoring/update', [MentoringController::class, 'update'])
        ->name('user.mentoring.update');
});

Route::get('/user/forgot-password',[ForgotPasswordController::class,'forgotPasswordForm'])->name('forgot_password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('send_reset_link');

Route::get('/reset-password-form/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password-store', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Academic Details Routes
Route::prefix('admin')->group(function () {
    // Session routes
    Route::get('/session', [AcademicDetailsController::class, 'sessions'])->name('admin.sessions');
    Route::get('/session/add-session', [AcademicDetailsController::class, 'addSession'])->name('admin.sessions.add');
    Route::post('/session', [AcademicDetailsController::class, 'storeSession'])->name('admin.sessions.store');
    Route::put('/session/{academicSession}', [AcademicDetailsController::class, 'updateSession'])->name('admin.sessions.update');
    Route::delete('/session/{academicSession}', [AcademicDetailsController::class, 'destroySession'])->name('admin.sessions.destroy');
    
    // Department routes
    Route::get('/department', [AcademicDetailsController::class, 'departments'])->name('admin.departments');
    Route::get('/department/add-department', [AcademicDetailsController::class, 'addDepartment'])->name('admin.departments.add');
    Route::post('/department', [AcademicDetailsController::class, 'storeDepartment'])->name('admin.departments.store');
    Route::put('/department/{department}', [AcademicDetailsController::class, 'updateDepartment'])->name('admin.departments.update');
    Route::delete('/department/{department}', [AcademicDetailsController::class, 'destroyDepartment'])->name('admin.departments.destroy');
    Route::get('/department/by-session/{sessionId}', [AcademicDetailsController::class, 'getDepartmentsBySession'])->name('admin.departments.by-session');
    
    // Semester routes
    Route::get('/semester', [AcademicDetailsController::class, 'semesters'])->name('admin.semesters');
    Route::get('/semester/add-semester', [AcademicDetailsController::class, 'addSemester'])->name('admin.semesters.add');
    Route::post('/semester', [AcademicDetailsController::class, 'storeSemester'])->name('admin.semesters.store');
    Route::put('/semester/{semester}', [AcademicDetailsController::class, 'updateSemester'])->name('admin.semesters.update');
    Route::delete('/semester/{semester}', [AcademicDetailsController::class, 'destroySemester'])->name('admin.semesters.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
