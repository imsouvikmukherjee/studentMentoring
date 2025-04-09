@extends('admin.layout.main')

@Section('main-container')

        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">

                <!-- <div class="breadcrumb-title pe-3">Semister Subjects</div> -->
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Department</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}" style="color: #00a8ff;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Department</li>

                            </ol>
                        </nav>
                    </div>

                    <div class="ms-auto"></div>
                    <div class="btn-group">
                        <a href="{{route('add_department')}}" class="btn btn-primary btn-sm">Add Department</a>

                    </div>


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


                        @if ($departments->isEmpty())
                        <p class="text-center text-muted my-3">No departments found at this time.</p>
                        @else

                            <div class="table-responsive mt-4">
                                <table class="table align-middle mb-0 text-center table-striped table-bordered">
                                    <thead class="table-primary ">
                                        <tr>
                                            <th>Sr No.</th>

                                            <th>Department</th>

                                            <th>Description</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>



                                    <tbody>

                                        @foreach($departments as $key => $item)

                                        <tr>
                                            <td>{{$key+1}}</td>

                                            <td>{{$item->department_name}}</td>

                                            <td>
                                                @if($item->description == null)
                                                    <span>N/A</span>
                                                @else
                                                    <span>{{$item->description}}</span>

                                                @endif
                                            </td>


                                            <td>
                                                <div>
                                                    <a class="dropdown-toggle dropdown-toggle-nocaret btn btn-light btn-sm" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu">


                                                        <li><a class="dropdown-item delete-btn" href="javascript:void(0)" onclick="confirmDelete('{{url('/delete-department')}}/{{encrypt($item->id)}}')" ><i class="bi bi-trash3"></i> Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>

                                        @endforeach


                                    </tbody>
                                    @endif
                                </table>

                            </div>
                            <div class="mt-3">
                                {{$departments->links('pagination::bootstrap-5')}}
                              </div>
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




            {{-- <script>
                document.addEventListener('DOMContentLoaded', function() {

                    const deleteButtons = document.querySelectorAll('.delete-btn');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function() {

                            const id = this.getAttribute('data-id');


                            Swal.fire({
                                title: "Are you sure?",
                                text: "You won't be able to revert this!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    fetch(`/delete-department/${id}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                            'Content-Type': 'application/json',
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {

                                            Swal.fire("Deleted!", "The department has been deleted.", "success")
                                                .then(() => {

                                                    location.reload();
                                                });
                                        } else {
                                            Swal.fire("Error!", "An error occurred while deleting the department.", "error");
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire("Error!", "An error occurred while deleting the department.", "error");
                                    });
                                }
                            });
                        });
                    });
                });
            </script> --}}


            <script>
                function confirmDelete(url){

                    // alert(url);
                    if(confirm('Are you sure?')){
                        window.location.href = url;
                    }

                }
            </script>

         @endsection

