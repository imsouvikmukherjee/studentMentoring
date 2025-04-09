@extends('student.layout.main')

@section('main-container')
<style>
    .edit-section {
        background: #fff;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .section-title {
        color: #344767;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    .section-title i {
        margin-right: 0.75rem;
        font-size: 1.2rem;
        color: #0d6efd;
    }
    .form-floating {
        margin-bottom: 1rem;
    }
    .form-floating > label {
        padding: 0.5rem 0.75rem;
    }
    .form-floating > .form-control {
        padding: 0.5rem 0.75rem;
        height: calc(3rem + 2px);
    }
    .achievement-form {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e9ecef;
    }
    .remove-achievement {
        color: #dc3545;
        cursor: pointer;
        transition: all 0.2s;
    }
    .remove-achievement:hover {
        transform: scale(1.1);
    }
    .add-more-btn {
        background: #e9ecef;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        color: #344767;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    .add-more-btn:hover {
        background: #dee2e6;
        transform: translateY(-1px);
    }
    .grade-select {
        width: 80px !important;
    }
    .subject-row {
        background: #fff;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 0.5rem;
        border: 1px solid #e9ecef;
    }
    .save-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        background: #0d6efd;
        color: #fff;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        z-index: 1000;
        transition: all 0.3s;
    }
    .save-btn:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
    }
    .semester-nav {
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 1000;
        padding: 1rem 0;
        margin-bottom: 2rem;
        border-bottom: 1px solid #e9ecef;
    }
</style>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Edit Mentoring Information</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.mentoring') }}">Mentoring</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Details</li>
            </ol>
        </nav>
    </div>
</div>

<form action="{{ route('user.mentoring.update') }}" method="POST" id="mentoringForm">
    @csrf
    <div class="semester-nav">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Semester <span id="currentSemester">1</span> Details</h4>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary prev-sem" disabled><i class="bi bi-chevron-left"></i> Previous</button>
                <button type="button" class="btn btn-outline-primary next-sem">Next <i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
        <div class="progress" style="height: 6px;">
            <div class="progress-bar" role="progressbar" style="width: 12.5%;" aria-valuenow="12.5" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    @for($sem = 1; $sem <= 8; $sem++)
    <div class="semester-section" data-semester="{{ $sem }}" style="{{ $sem > 1 ? 'display: none;' : '' }}">
        <!-- Academic Performance -->
        <div class="edit-section">
            <h5 class="section-title"><i class="bi bi-journal-text"></i>Academic Performance</h5>
            <div class="subject-container">
                @foreach($semesterSubjects[$sem] ?? [] as $index => $subject)
                <div class="subject-row">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="subject_{{ $sem }}_{{ $index }}" name="semesters[{{ $sem }}][subjects][{{ $index }}][name]" value="{{ $subject->name }}" placeholder="Subject Name">
                                <label>Subject Name</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][subjects][{{ $index }}][code]" value="{{ $subject->code }}" placeholder="Subject Code">
                                <label>Code</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <select class="form-select grade-select" name="semesters[{{ $sem }}][subjects][{{ $index }}][grade]">
                                    @foreach(['O', 'E', 'A', 'B', 'C', 'D', 'F'] as $grade)
                                        <option value="{{ $grade }}" {{ $subject->grade == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                    @endforeach
                                </select>
                                <label>Grade</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][subjects][{{ $index }}][remarks]" value="{{ $subject->remarks }}" placeholder="Remarks">
                                <label>Remarks</label>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">
                            <i class="bi bi-trash remove-subject remove-achievement"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="add-more-btn mt-2" data-type="subject" data-semester="{{ $sem }}">
                <i class="bi bi-plus-circle"></i> Add Subject
            </button>
        </div>

        <!-- Certifications -->
        <div class="edit-section">
            <h5 class="section-title"><i class="bi bi-award"></i>Certifications</h5>
            <div class="certifications-container">
                @foreach($certifications[$sem] ?? [] as $index => $cert)
                <div class="achievement-form">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][certifications][{{ $index }}][title]" value="{{ $cert->title }}" placeholder="Certificate Title">
                                <label>Certificate Title</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][certifications][{{ $index }}][issuer]" value="{{ $cert->issuer }}" placeholder="Issuing Organization">
                                <label>Issuing Organization</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="semesters[{{ $sem }}][certifications][{{ $index }}][completion_date]" value="{{ $cert->completion_date }}">
                                <label>Completion Date</label>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="bi bi-trash remove-achievement"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="add-more-btn mt-2" data-type="certification" data-semester="{{ $sem }}">
                <i class="bi bi-plus-circle"></i> Add Certification
            </button>
        </div>

        <!-- Workshops -->
        <div class="edit-section">
            <h5 class="section-title"><i class="bi bi-tools"></i>Workshops</h5>
            <div class="workshops-container">
                @foreach($workshops[$sem] ?? [] as $index => $workshop)
                <div class="achievement-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][workshops][{{ $index }}][name]" value="{{ $workshop->name }}" placeholder="Workshop Name">
                                <label>Workshop Name</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][workshops][{{ $index }}][organizer]" value="{{ $workshop->organizer }}" placeholder="Organizer">
                                <label>Organizer</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="semesters[{{ $sem }}][workshops][{{ $index }}][date]" value="{{ $workshop->date }}">
                                <label>Date</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][workshops][{{ $index }}][duration]" value="{{ $workshop->duration }}" placeholder="Duration">
                                <label>Duration</label>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="bi bi-trash remove-achievement"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="add-more-btn mt-2" data-type="workshop" data-semester="{{ $sem }}">
                <i class="bi bi-plus-circle"></i> Add Workshop
            </button>
        </div>

        <!-- Internships -->
        <div class="edit-section">
            <h5 class="section-title"><i class="bi bi-briefcase"></i>Internships</h5>
            <div class="internships-container">
                @foreach($internships[$sem] ?? [] as $index => $internship)
                <div class="achievement-form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][internships][{{ $index }}][company]" value="{{ $internship->company }}" placeholder="Company Name">
                                <label>Company Name</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][internships][{{ $index }}][role]" value="{{ $internship->role }}" placeholder="Role/Position">
                                <label>Role/Position</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][internships][{{ $index }}][duration]" value="{{ $internship->duration }}" placeholder="Duration">
                                <label>Duration</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <textarea class="form-control" name="semesters[{{ $sem }}][internships][{{ $index }}][description]" placeholder="Description" style="height: 100px">{{ $internship->description }}</textarea>
                                <label>Description</label>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="bi bi-trash remove-achievement"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="add-more-btn mt-2" data-type="internship" data-semester="{{ $sem }}">
                <i class="bi bi-plus-circle"></i> Add Internship
            </button>
        </div>

        <!-- Challenges/Competitions -->
        <div class="edit-section">
            <h5 class="section-title"><i class="bi bi-trophy"></i>Challenges & Competitions</h5>
            <div class="challenges-container">
                @foreach($challenges[$sem] ?? [] as $index => $challenge)
                <div class="achievement-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][challenges][{{ $index }}][name]" value="{{ $challenge->name }}" placeholder="Challenge Name">
                                <label>Challenge Name</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][challenges][{{ $index }}][organizer]" value="{{ $challenge->organizer }}" placeholder="Organizer">
                                <label>Organizer</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="semesters[{{ $sem }}][challenges][{{ $index }}][result]" value="{{ $challenge->result }}" placeholder="Result">
                                <label>Result</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="semesters[{{ $sem }}][challenges][{{ $index }}][date]" value="{{ $challenge->date }}">
                                <label>Date</label>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="bi bi-trash remove-achievement"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="add-more-btn mt-2" data-type="challenge" data-semester="{{ $sem }}">
                <i class="bi bi-plus-circle"></i> Add Challenge
            </button>
        </div>
    </div>
    @endfor

    <button type="submit" class="save-btn">
        <i class="bi bi-check2-circle"></i> Save All Changes
    </button>
</form>

@push('scripts')
<script>
$(document).ready(function() {
    let currentSemester = 1;
    const totalSemesters = 8;

    // Navigation between semesters
    $('.next-sem').click(function() {
        if (currentSemester < totalSemesters) {
            $(`[data-semester="${currentSemester}"]`).hide();
            currentSemester++;
            $(`[data-semester="${currentSemester}"]`).show();
            updateNavigation();
        }
    });

    $('.prev-sem').click(function() {
        if (currentSemester > 1) {
            $(`[data-semester="${currentSemester}"]`).hide();
            currentSemester--;
            $(`[data-semester="${currentSemester}"]`).show();
            updateNavigation();
        }
    });

    function updateNavigation() {
        $('#currentSemester').text(currentSemester);
        $('.prev-sem').prop('disabled', currentSemester === 1);
        $('.next-sem').prop('disabled', currentSemester === totalSemesters);
        $('.progress-bar').css('width', `${(currentSemester/totalSemesters)*100}%`);
    }

    // Add new items
    $('.add-more-btn').click(function() {
        const type = $(this).data('type');
        const semester = $(this).data('semester');
        const container = $(this).siblings(`.${type}s-container`);
        const index = container.children().length;
        
        let template = '';
        switch(type) {
            case 'subject':
                template = getSubjectTemplate(semester, index);
                break;
            case 'certification':
                template = getCertificationTemplate(semester, index);
                break;
            case 'workshop':
                template = getWorkshopTemplate(semester, index);
                break;
            case 'internship':
                template = getInternshipTemplate(semester, index);
                break;
            case 'challenge':
                template = getChallengeTemplate(semester, index);
                break;
        }
        
        container.append(template);
    });

    // Remove items
    $(document).on('click', '.remove-achievement', function() {
        $(this).closest('.achievement-form, .subject-row').fadeOut(300, function() {
            $(this).remove();
        });
    });

    // Form submission
    $('#mentoringForm').submit(function(e) {
        e.preventDefault();
        
        // Show loading state
        $('.save-btn').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Saving...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showNotification('success', 'Changes saved successfully!');
                    setTimeout(() => {
                        window.location.href = '{{ route("user.mentoring") }}';
                    }, 1500);
                } else {
                    showNotification('error', 'Error saving changes. Please try again.');
                    $('.save-btn').prop('disabled', false).html('<i class="bi bi-check2-circle"></i> Save All Changes');
                }
            },
            error: function() {
                showNotification('error', 'Error saving changes. Please try again.');
                $('.save-btn').prop('disabled', false).html('<i class="bi bi-check2-circle"></i> Save All Changes');
            }
        });
    });

    function showNotification(type, message) {
        const toast = `
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        `;
        
        $(toast).appendTo('body').find('.toast').toast('show');
    }

    // Template generators
    function getSubjectTemplate(semester, index) {
        return `
            <div class="subject-row">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="semesters[${semester}][subjects][${index}][name]" placeholder="Subject Name" required>
                            <label>Subject Name</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="semesters[${semester}][subjects][${index}][code]" placeholder="Subject Code">
                            <label>Code</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <select class="form-select grade-select" name="semesters[${semester}][subjects][${index}][grade]">
                                <option value="">Select</option>
                                <option value="O">O</option>
                                <option value="E">E</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="F">F</option>
                            </select>
                            <label>Grade</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="semesters[${semester}][subjects][${index}][remarks]" placeholder="Remarks">
                            <label>Remarks</label>
                        </div>
                    </div>
                    <div class="col-md-1 text-center">
                        <i class="bi bi-trash remove-achievement"></i>
                    </div>
                </div>
            </div>
        `;
    }

    function getCertificationTemplate(semester, index) {
        return `
            <div class="achievement-form">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="semesters[${semester}][certifications][${index}][title]" placeholder="Certificate Title" required>
                            <label>Certificate Title</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="semesters[${semester}][certifications][${index}][issuer]" placeholder="Issuing Organization">
                            <label>Issuing Organization</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="date" class="form-control" name="semesters[${semester}][certifications][${index}][completion_date]">
                            <label>Completion Date</label>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                        <i class="bi bi-trash remove-achievement"></i>
                    </div>
                </div>
            </div>
        `;
    }

    // Similar template generators for workshops, internships, and challenges...
});
</script>
@endpush
@endsection 