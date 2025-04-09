@extends('admin.layout.main')

@Section('main-container')

        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">

                <!-- <div class="breadcrumb-title pe-3">Semister Subjects</div> -->
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Mentoring Info</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}" style="color: #00a8ff;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Mentoring Info</li>

                            </ol>
                        </nav>
                    </div>

                    <div class="ms-auto"></div>
                    <div class="btn-group">
                        <a href="{{route('assign_mentors')}}" class="btn btn-primary btn-sm">Assign Mentor</a>

                    </div>


                </div>
                <!--end breadcrumb-->

                <div class="row mt-4">
                    <div class="col-12 col-lg-12">
                        <div class="card radius-10">
                            <div class="card-body">

                                <!-- <div class="d-flex justify-content-end">
                                    <a href="add-subject.html" class="btn btn-light "><i class="bi bi-plus-lg"></i></a>
                                    <a href="" class="btn btn-light  "><i class="bi bi-arrow-clockwise"></i></a>
                                </div> -->

                                @if (session('success'))
                                <div class="alert alert-success text-center border-0 alert-dismissible fade show">
                                    {!! session('success') !!}
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form id="bulk-delete-form" method="POST" action="{{ route('assignedmentees.bulk-delete') }}">
                                @csrf
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="select-all">

                                                      </div>
                                                </th>
                                                <th>Sl No.</th>
                                                <th>Session</th>
                                                <th>Department</th>
                                                <th>Mentee Name</th>
                                                <th>Email</th>

                                                <th>Mentor Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assignedData as $key => $item)

                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input item-checkbox" name="selected_ids[]" type="checkbox" value="{{ $item->id }}" id="flexCheckDefault">

                                                      </div>
                                                </td>
                                                <td>{{$key+1}}</td>
                                                <td>{{$item->session}}</td>
                                                <td>{{$item->department_name}}</td>
                                                <td>{{$item->mentee_name}}</td>
                                                <td>{{$item->mentee_email}}</td>
                                                <td class="text-success">{{$item->mentor_name}}</td>

                                                <td>
                                                    <div>
                                                        <a class="dropdown-toggle dropdown-toggle-nocaret btn btn-light btn-sm" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i>
									</a>
                                                        <ul class="dropdown-menu">

                                                            {{-- <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-info-square"></i> Info</a>
                                                            </li> --}}

                                                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="confirmDelete('{{url('admin/assign-mentor-delete')}}/{{encrypt($item->id)}}')"><i class="bi bi-trash3"></i> Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            @endforeach


                                        </tbody>
                                        {{-- <tfoot>
                                            <tr>
                                                <th>Session</th>
                                                <th>Department</th>
                                                <th>Student Name</th>
                                                <th>Email</th>

                                                <th>Mentor Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot> --}}
                                    </table>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-light btn-sm my-3 disabled-link" id="delete-selected"><i class="fadeIn animated bx bx-trash"></i>Delete All</a>

                                <a href="#" class="btn btn-light  btn-sm my-3"><i class="fadeIn animated bx bx-printer"></i>Print</a>
                                <a href="#" class="btn btn-light  btn-sm my-3"><i class='bx bx-download'></i>Download PDF</a>
                            </form>
                            </div>
                        </div>
                    </div>

                    <!--end page wrapper -->
                    <!--start overlay-->
                    <div class="overlay toggle-icon"></div>
                    <!--end overlay-->
                    <!--Start Back To Top Button--><a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
                    <!--End Back To Top Button-->
                    <footer class="page-footer">
                        <p class="mb-0">Copyright © 2024. All right reserved.</p>
                    </footer>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const selectAllCheckbox = document.getElementById('select-all');
                        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
                        const deleteButton = document.getElementById('delete-selected');
                        const bulkDeleteForm = document.getElementById('bulk-delete-form');

                        selectAllCheckbox.addEventListener('change', function () {
                            itemCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                            toggleDeleteButton();
                        });

                        itemCheckboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', toggleDeleteButton);
                        });

                        function toggleDeleteButton() {
                            const anyChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                            deleteButton.classList.toggle('disabled-link', !anyChecked);
                        }

                        deleteButton.addEventListener('click', function () {
                            if (!deleteButton.classList.contains('disabled-link') && confirm('Are you sure you want to delete the selected items?')) {
                                bulkDeleteForm.submit();
                            }
                        });
                    });
                </script>

                <style>
                    .disabled-link {
                        pointer-events: none;
                        opacity: 0.5;
                    }
                </style>
                <script>
                    function confirmDelete(url){
                        if(confirm('Are you sure?')){
                            window.location.href = url;
                        }
                    }
                </script>
             @endsection
