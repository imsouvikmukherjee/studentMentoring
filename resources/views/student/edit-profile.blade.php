@extends('student.layout.main')

@section('main-container')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Profile</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h5 class="mb-0">Edit Profile</h5>
                <p class="text-muted">Update your personal information</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>

        @if($pendingRequest)
        <div class="alert border-0 border-start border-5 border-warning py-2 mb-4">
            <div class="d-flex align-items-center">
                <div class="font-35 text-warning"><i class="bx bx-time-five"></i></div>
                <div class="ms-3">
                    <h6 class="mb-0 text-warning">Pending Change Request</h6>
                    <div>You already have a pending profile change request. Please wait for it to be processed before submitting another request.</div>
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="alert border-0 border-start border-5 border-danger py-2 mb-4">
            <div class="d-flex align-items-center">
                <div class="font-35 text-danger"><i class="bx bx-error-circle"></i></div>
                <div class="ms-3">
                    <h6 class="mb-0 text-danger">Form Errors</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Profile Picture</h6>
                                </div>
                        <div class="card-body text-center">
                            <div class="profile-pic-wrapper mb-3">
                                <img src="{{ $student && isset($student->profile_picture) && $student->profile_picture ? url('storage/profile-pictures/' . $student->profile_picture) : url('admin-assets/images/avatars/avatar-2.png') }}"
                                    class="img-fluid rounded-circle profile-pic"
                                    width="150" height="150"
                                    alt="Profile Picture">
                            </div>

                            @if($pendingRequest)
                                <div class="alert alert-warning py-2 small">
                                    Please wait for your pending change request to be processed.
                            </div>
                            @else
                            <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Change Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                                    <div class="mt-2">
                                        {{-- <small class="text-muted">You can change your profile picture {{ $student->picture_changes_left ?? 3 }} more {{ $student->picture_changes_left == 1 ? 'time' : 'times' }}.</small> --}}
                            </div>
                            </div>
                            @endif

                            <div class="user-info mt-3">
                                <h6 class="mb-1">{{ $student->name ?? 'Student' }}</h6>
                                <p class="text-muted small mb-0">{{ $student->email ?? 'Email not available' }}</p>
                                <p class="text-muted mb-0"><i class="bi bi-phone me-1"></i> {{ $student->contact ?? 'Contact not available' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <!-- Personal Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-person-fill me-2"></i>Personal Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $student->dob ? date('Y-m-d', strtotime($student->dob)) : '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality', $student->nationality ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="category" name="category" required {{ $pendingRequest ? 'disabled' : '' }}>
                                        <option value="">Select Category</option>
                                        <option value="General" {{ (old('category', $student->category ?? '') == 'General') ? 'selected' : '' }}>General</option>
                                        <option value="OBC" {{ (old('category', $student->category ?? '') == 'OBC') ? 'selected' : '' }}>OBC</option>
                                        <option value="SC" {{ (old('category', $student->category ?? '') == 'SC') ? 'selected' : '' }}>SC</option>
                                        <option value="ST" {{ (old('category', $student->category ?? '') == 'ST') ? 'selected' : '' }}>ST</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="sex" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" id="sex" name="sex" required {{ $pendingRequest ? 'disabled' : '' }}>
                                        <option value="">Select Gender</option>
                                        <option value="M" {{ (old('sex', $student->sex ?? '') == 'M') ? 'selected' : '' }}>Male</option>
                                        <option value="F" {{ (old('sex', $student->sex ?? '') == 'F') ? 'selected' : '' }}>Female</option>
                                        <option value="O" {{ (old('sex', $student->sex ?? '') == 'O') ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="father_name" class="form-label">Father's Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="father_name" name="father_name" value="{{ old('father_name', $student->father_name ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="mother_name" class="form-label">Mother's Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{ old('mother_name', $student->mother_name ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="blood_group" class="form-label">Blood Group</label>
                                    <select class="form-select" id="blood_group" name="blood_group" {{ $pendingRequest ? 'disabled' : '' }}>
                                        <option value="">Select Blood Group</option>
                                        <option value="A+" {{ (old('blood_group', $student->blood_group ?? '') == 'A+') ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ (old('blood_group', $student->blood_group ?? '') == 'A-') ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ (old('blood_group', $student->blood_group ?? '') == 'B+') ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ (old('blood_group', $student->blood_group ?? '') == 'B-') ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ (old('blood_group', $student->blood_group ?? '') == 'AB+') ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ (old('blood_group', $student->blood_group ?? '') == 'AB-') ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ (old('blood_group', $student->blood_group ?? '') == 'O+') ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ (old('blood_group', $student->blood_group ?? '') == 'O-') ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="religion" class="form-label">Religion</label>
                                    <input type="text" class="form-control" id="religion" name="religion" value="{{ old('religion', $student->religion ?? '') }}" {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="aadhaar_no" class="form-label">Aadhaar No</label>
                                    <input type="text" class="form-control" id="aadhaar_no" name="aadhaar_no" value="{{ old('aadhaar_no', $student->aadhaar_no ?? '') }}" {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-telephone-fill me-2"></i>Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="student_address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="student_address" name="student_address" rows="2" required {{ $pendingRequest ? 'disabled' : '' }}>{{ old('student_address', $student->student_address ?? '') }}</textarea>
                            </div>

                                <div class="col-md-6">
                                <label for="alternate_mobile" class="form-label">Alternate Mobile Number</label>
                                <input type="text" class="form-control" id="alternate_mobile" name="alternate_mobile" value="{{ old('alternate_mobile', $student->alternate_mobile ?? '') }}" {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $student->state ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="district" name="district" value="{{ old('district', $student->district ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="pin" class="form-label">PIN Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pin" name="pin" value="{{ old('pin', $student->pin ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                            </div>

                                <div class="col-md-6">
                                <label class="form-label">Primary Mobile Number</label>
                                <input type="text" class="form-control" value="{{ $student->contact ?? '' }}" readonly disabled>
                                    <small class="text-muted">Primary contact requires administrator approval for changes.</small>
                            </div>

                                <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ $student->email ?? '' }}" readonly disabled>
                                    <small class="text-muted">Email requires administrator approval for changes.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-people-fill me-2"></i>Guardian Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="gurdian_name" class="form-label">Guardian Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="gurdian_name" name="gurdian_name" value="{{ old('gurdian_name', $student->gurdian_name ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label for="guardian_mobile" class="form-label">Guardian Mobile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="guardian_mobile" name="guardian_mobile" value="{{ old('guardian_mobile', $student->guardian_mobile ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label for="gurdian_address" class="form-label">Guardian Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="gurdian_address" name="gurdian_address" rows="2" required {{ $pendingRequest ? 'disabled' : '' }}>{{ old('gurdian_address', $student->gurdian_address ?? '') }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="relation_with_guardian" class="form-label">Relation with Guardian <span class="text-danger">*</span></label>
                                    <select class="form-select" id="relation_with_guardian" name="relation_with_guardian" required {{ $pendingRequest ? 'disabled' : '' }}>
                                        <option value="">Select Relation</option>
                                        <option value="Father" {{ (old('relation_with_guardian', $student->relation_with_guardian ?? '') == 'Father') ? 'selected' : '' }}>Father</option>
                                        <option value="Mother" {{ (old('relation_with_guardian', $student->relation_with_guardian ?? '') == 'Mother') ? 'selected' : '' }}>Mother</option>
                                        <option value="Brother" {{ (old('relation_with_guardian', $student->relation_with_guardian ?? '') == 'Brother') ? 'selected' : '' }}>Brother</option>
                                        <option value="Sister" {{ (old('relation_with_guardian', $student->relation_with_guardian ?? '') == 'Sister') ? 'selected' : '' }}>Sister</option>
                                        <option value="Uncle" {{ (old('relation_with_guardian', $student->relation_with_guardian ?? '') == 'Uncle') ? 'selected' : '' }}>Uncle</option>
                                        <option value="Aunt" {{ (old('relation_with_guardian', $student->relation_with_guardian ?? '') == 'Aunt') ? 'selected' : '' }}>Aunt</option>
                                        <option value="Other" {{ (old('relation_with_guardian', $student->relation_with_guardian ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="residence_status" class="form-label">Residence Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="residence_status" name="residence_status" required {{ $pendingRequest ? 'disabled' : '' }}>
                                        <option value="">Select Status</option>
                                        <option value="Resident" {{ (old('residence_status', $student->residence_status ?? '') == 'Resident') ? 'selected' : '' }}>Resident</option>
                                        <option value="Non-Resident" {{ (old('residence_status', $student->residence_status ?? '') == 'Non-Resident') ? 'selected' : '' }}>Non-Resident</option>
                                        <option value="Hostel" {{ (old('residence_status', $student->residence_status ?? '') == 'Hostel') ? 'selected' : '' }}>Hostel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-mortarboard-fill me-2"></i>Academic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="session" class="form-label">Session <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="session" name="session" value="{{ old('session', $student->session ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="reg_no" class="form-label">Registration No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reg_no" name="reg_no" value="{{ old('reg_no', $student->reg_no ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-4">
                                    <label for="roll_no" class="form-label">Roll No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="roll_no" name="roll_no" value="{{ old('roll_no', $student->roll_no ?? '') }}" required {{ $pendingRequest ? 'disabled' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Department</label>
                                    <input type="text" class="form-control" value="{{ $student->department_name ?? '' }}" readonly disabled>
                                    <small class="text-muted">Department changes require administrator approval.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert border-0 border-start border-5 border-info py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-info"><i class="bi bi-info-circle"></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-info">Important Information</h6>
                                <ul class="mb-0">
                                    <li>All changes to your profile information require approval from your mentor.</li>
                                    <li>Your profile picture can be changed up to 3 times without approval.</li>
                                    <li>You will be notified when your change request is approved or rejected.</li>
                                    <li>For emergency changes, please contact the administrator directly.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4" {{ $pendingRequest ? 'disabled' : '' }}><i class="bi bi-save"></i> Submit Change Request</button>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary px-4 ms-2"><i class="bi bi-x-circle"></i> Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.profile-pic-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 50%;
    background-color: #f8f9fa;
    border: 4px solid #e9ecef;
}

.profile-pic {
    object-fit: cover;
    width: 100%;
    height: 100%;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,.125);
}
</style>
@endsection
