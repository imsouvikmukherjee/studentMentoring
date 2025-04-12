@extends('admin.layout.main')

@section('main-container')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Semester</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}" style="color: #00a8ff;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('admin.semesters')}}">Semesters</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Semester</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        @if ($errors->any())
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <ul class="text-white">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="p-4 border rounded">
                    <form action="{{ route('admin.semesters.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="semester_session_id" class="form-label">Session</label>
                                <select class="form-select" id="semester_session_id" required>
                                    <option value="">Select Session</option>
                                    @foreach($sessions as $session)
                                    <option value="{{ $session->id }}" {{ old('academic_session_id') == $session->id ? 'selected' : '' }}>{{ $session->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="semester_department_id" class="form-label">Department</label>
                                <select class="form-select" id="semester_department_id" name="department_id" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }} data-session="{{ $department->academic_session_id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Semester Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="even_semester" value="even" {{ old('type') == 'even' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="even_semester">
                                        Even Semester
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="odd_semester" value="odd" {{ old('type') == 'odd' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="odd_semester">
                                        Odd Semester
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Select Months</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="jan" value="January" {{ is_array(old('months')) && in_array('January', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jan">January</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="feb" value="February" {{ is_array(old('months')) && in_array('February', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="feb">February</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="mar" value="March" {{ is_array(old('months')) && in_array('March', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mar">March</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="apr" value="April" {{ is_array(old('months')) && in_array('April', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="apr">April</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="may" value="May" {{ is_array(old('months')) && in_array('May', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="may">May</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="jun" value="June" {{ is_array(old('months')) && in_array('June', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jun">June</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="jul" value="July" {{ is_array(old('months')) && in_array('July', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jul">July</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="aug" value="August" {{ is_array(old('months')) && in_array('August', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="aug">August</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="sep" value="September" {{ is_array(old('months')) && in_array('September', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sep">September</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="oct" value="October" {{ is_array(old('months')) && in_array('October', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="oct">October</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="nov" value="November" {{ is_array(old('months')) && in_array('November', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nov">November</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="months[]" id="dec" value="December" {{ is_array(old('months')) && in_array('December', old('months')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="dec">December</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Add Semester</button>
                                <a href="{{ route('admin.semesters') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sessionSelect = document.getElementById('semester_session_id');
        const departmentSelect = document.getElementById('semester_department_id');
        
        // Hide all department options initially except the placeholder
        function filterDepartments() {
            const selectedSessionId = sessionSelect.value;
            
            // Hide all department options
            Array.from(departmentSelect.options).forEach(option => {
                if (option.value === '') {
                    // Keep the placeholder visible
                    option.style.display = '';
                } else {
                    const sessionId = option.getAttribute('data-session');
                    if (selectedSessionId === '' || sessionId === selectedSessionId) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                }
            });
            
            // Reset department selection if current selection is not valid for new session
            const currentDeptOption = departmentSelect.options[departmentSelect.selectedIndex];
            if (currentDeptOption.style.display === 'none') {
                departmentSelect.value = '';
            }
        }
        
        // Filter departments when session changes
        sessionSelect.addEventListener('change', filterDepartments);
        
        // Initial filtering
        filterDepartments();
    });
</script>
@endpush

@endsection 