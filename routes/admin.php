<?php

use App\Http\Controllers\Admin\AssignedmentorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MenteeController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ChangeRequestController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth','isStudent')->group(function () {
Route::get('/admin/dashboard',[DashboardController::class,'adminDashboard'])->name('admin_dashboard');
Route::get('/admin/department',[DepartmentController::class,'department'])->name('department');
Route::get('/admin/add-department',[DepartmentController::class,'addDepartment'])->name('add_department');
Route::post('/admin/add-department-store',[DepartmentController::class,'addDepartmentStore'])->name('add_department_store');

Route::get('/delete-department/{id}', [DepartmentController::class, 'destroy']);

Route::get('/admin/subjects',[SubjectController::class,'subject'])->name('subject');
Route::get('/admin/add-subject',[SubjectController::class,'addSubject'])->name('add_subject');
Route::post('/admin/add-subject-store',[SubjectController::class,'addSubjectStore'])->name('add_subject_store');
Route::get('/admin/delete-subject/{id}',[SubjectController::class,'subjectDelete']);

// Subject assignment routes
Route::get('/admin/assign-subjects', [SubjectController::class, 'assignSubjects'])->name('assign.subjects');
Route::get('/admin/students-by-department', [SubjectController::class, 'getStudentsByDepartment']);
Route::get('/admin/subjects-by-department', [SubjectController::class, 'getSubjectsByDepartment']);
Route::post('/admin/assign-subjects-store', [SubjectController::class, 'assignSubjectsStore'])->name('assign.subjects.store');

Route::get('/admin/users',[UserController::class,'adminUser'])->name('admin_user');
Route::get('/admin/add-user',[UserController::class,'addUser'])->name('add_user');
Route::post('/admin/add-user-store',[UserController::class,'addUserStore'])->name('add_user_store');
Route::get('/admin/user-delete/{id}',[UserController::class,'userDelete']);
Route::get('admin/reset-password/{id}',[UserController::class,'resetPassword'])->name('reset_password');
Route::post('admin/reset-password-store/{id}',[UserController::class,'resetPasswordStore'])->name('reset_password_store');
Route::get('/admin/add-mentees',[MenteeController::class,'addMentee'])->name('add_mentee');
Route::post('/admin/add-mentees-store',[MenteeController::class,'addMenteeStore'])->name('add_mentee_store');
Route::get('/admin/mentees',[MenteeController::class,'mentees'])->name('mentee');
Route::get('/admin/mentee-delete/{id}',[MenteeController::class,'menteeDelete'])->name('mentee_delete');
Route::get('/admin/mentee-modify/{id}',[MenteeController::class,'editMentee'])->name('edit_mentee');
Route::post('/admin/modify-mentee/store/{id}',[MenteeController::class,'editMenteeStore'])->name('edit_mentee_store');
Route::get('/admin/mentee-info/{id}',[MenteeController::class,'menteeInfo'])->name('mentee_info');
Route::post('/admin/mentees/bulk-delete', [MenteeController::class, 'bulkDelete'])->name('mentees.bulk-delete');


Route::get('/admin/view-assigned-mentors',[AssignedmentorController::class,'viewAssignedMentor'])->name('view_assign_mentors');
Route::get('/admin/assign-mentor',[AssignedmentorController::class,'assignMentor'])->name('assign_mentors');
Route::post('/filter-mentees', [AssignedmentorController::class, 'filterMentees'])->name('filter.mentees');
Route::post('/assign-mentor/store', [AssignedmentorController::class, 'assignMentorStore'])->name('assign.mentors.store');
Route::get('/admin/assign-mentor-delete/{id}', [AssignedmentorController::class, 'assignMentorDelete']);
Route::post('/admin/assigned-mentees/bulk-delete', [AssignedmentorController::class, 'bulkDelete'])->name('assignedmentees.bulk-delete');

// Change Requests Management
Route::get('/change-requests', [ChangeRequestController::class, 'index'])->name('admin.change-requests');
Route::get('/change-requests/{id}', [ChangeRequestController::class, 'show'])->name('admin.change-requests.show');
Route::post('/change-requests/{id}/approve', [ChangeRequestController::class, 'approve'])->name('admin.change-requests.approve');
Route::post('/change-requests/{id}/reject', [ChangeRequestController::class, 'reject'])->name('admin.change-requests.reject');

});


