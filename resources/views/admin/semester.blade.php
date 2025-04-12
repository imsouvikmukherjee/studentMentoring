@extends('admin.layout.main')

@section('main-container')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Semesters</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}" style="color: #00a8ff;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Semesters</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.semesters.add') }}" class="btn btn-primary">Add Semester</a>
            </div>
        </div>
        <!--end breadcrumb-->

        @if (session('success'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white">{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Session</th>
                                <th>Department</th>
                                <th>Type</th>
                                <th>Months</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($semesters->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">No semesters found</td>
                                </tr>
                            @else
                                @foreach($semesters as $semester)
                                <tr>
                                    <td>{{ $semester->id }}</td>
                                    <td>{{ $semester->department->academicSession->name }}</td>
                                    <td>{{ $semester->department->name }}</td>
                                    <td>{{ ucfirst($semester->type) }}</td>
                                    <td>{{ implode(', ', $semester->months) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSemesterModal{{ $semester->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('admin.semesters.destroy', $semester->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this semester?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal for Semester -->
                                <div class="modal fade" id="editSemesterModal{{ $semester->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Semester</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.semesters.update', $semester->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="edit_semester_session_id{{ $semester->id }}" class="form-label">Session</label>
                                                        <select class="form-select edit-semester-session" id="edit_semester_session_id{{ $semester->id }}" name="academic_session_id" required data-semester-id="{{ $semester->id }}">
                                                            @foreach(\App\Models\AcademicSession::all() as $session)
                                                            <option value="{{ $session->id }}" {{ $semester->department->academic_session_id == $session->id ? 'selected' : '' }}>{{ $session->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_semester_department_id{{ $semester->id }}" class="form-label">Department</label>
                                                        <select class="form-select" id="edit_semester_department_id{{ $semester->id }}" name="department_id" required>
                                                            @foreach(\App\Models\Department::all() as $department)
                                                            <option value="{{ $department->id }}" {{ $semester->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Semester Type</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="edit_even_semester{{ $semester->id }}" value="even" {{ $semester->type == 'even' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="edit_even_semester{{ $semester->id }}">
                                                                Even Semester
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="edit_odd_semester{{ $semester->id }}" value="odd" {{ $semester->type == 'odd' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="edit_odd_semester{{ $semester->id }}">
                                                                Odd Semester
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Select Months</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                @php
                                                                    $semesterMonths = $semester->months;
                                                                @endphp
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_jan{{ $semester->id }}" value="January" {{ in_array('January', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_jan{{ $semester->id }}">January</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_feb{{ $semester->id }}" value="February" {{ in_array('February', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_feb{{ $semester->id }}">February</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_mar{{ $semester->id }}" value="March" {{ in_array('March', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_mar{{ $semester->id }}">March</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_apr{{ $semester->id }}" value="April" {{ in_array('April', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_apr{{ $semester->id }}">April</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_may{{ $semester->id }}" value="May" {{ in_array('May', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_may{{ $semester->id }}">May</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_jun{{ $semester->id }}" value="June" {{ in_array('June', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_jun{{ $semester->id }}">June</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_jul{{ $semester->id }}" value="July" {{ in_array('July', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_jul{{ $semester->id }}">July</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_aug{{ $semester->id }}" value="August" {{ in_array('August', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_aug{{ $semester->id }}">August</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_sep{{ $semester->id }}" value="September" {{ in_array('September', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_sep{{ $semester->id }}">September</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_oct{{ $semester->id }}" value="October" {{ in_array('October', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_oct{{ $semester->id }}">October</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_nov{{ $semester->id }}" value="November" {{ in_array('November', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_nov{{ $semester->id }}">November</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="months[]" id="edit_dec{{ $semester->id }}" value="December" {{ in_array('December', $semesterMonths) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_dec{{ $semester->id }}">December</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Semester</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 