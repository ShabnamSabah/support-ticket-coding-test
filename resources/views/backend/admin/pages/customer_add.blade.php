@extends('backend.admin.includes.admin_layout')
@push('css')
@endpush
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class=" text-center mb-2">Operator Add</h3>
                        @if (session('success'))
                            <div style="width:100%" class="alert alert-primary alert-dismissible fade show" role="alert">
                                <strong> Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="btn-close"></button>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Failed!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="btn-close"></button>
                            </div>
                        @endif
                        <form action="{{ route('admin.operator.add') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="form-label"> Name *</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Enter Operator Name" required>
                                </div>
                            
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="">Email *</label>
                                    <input type="email" name="email" placeholder="Enter Email" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="">Password *</label>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
                                </div>
                               
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="">Phone *</label>
                                    <input type="text" class="form-control" placeholder="Enter Phone" name="phone" required>
                                </div>
                               
                                <div class="col-md-3">
                                    <label for="" class="form-label"> Tagline </label>
                                    <input type="text" class="form-control" name="tagline"
                                        placeholder="Enter Tagline">
                                </div>

                              

                                <div class="col-md-3 mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Upload Photo</label>
                                        <input name="photo" class="form-control" type="file" id="imgPreview"
                                            onchange="readpicture(this, '#imgPreviewId');">
                                    </div>
                                    <div class="text-center">
                                        <img id="imgPreviewId" onclick="image_upload()"
                                            src="{{ asset('backend_assets/images/uploads_preview.png') }}">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="issue_date" class="form-label">Introduction</label>
                                    <textarea class="form-control" name="introduction" rows="3" placeholder="Write Something About Operator"></textarea>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <button class="btn btn-xs btn-primary" type="submit">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function image_upload() {

            $('#imgPreview').trigger('click');
        }

        function readpicture(input, preview_id) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(preview_id)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }

        }
    </script>
@endpush
