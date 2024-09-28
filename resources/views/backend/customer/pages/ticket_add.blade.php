@extends('backend.customer.includes.customer_layout')
@push('css')
<link rel="stylesheet" href="{{ asset('backend_assets/css/ckeditor.css') }}">
@endpush
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class=" text-center mb-2">Ticket Add</h3>
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
                        <form action="{{ route('customer.ticket.add') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="form-label">Name *</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Enter Ticket Name" required> 
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="issue_date" class="form-label">Issue Date * </label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" name="issue_date" value="" id="news_date"
                                            class="form-control" placeholder="Select date" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i
                                                data-feather="calendar"></i></span>
                                    </div>
                                </div>

                               
                                <div class="col-md-12 mb-3">
                                    <label for="issue_date" class="form-label">Description</label>
                                    <textarea name="description" id="editor" style="width:100%" cols="20" rows="5"></textarea>
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
   
<script src="{{ asset('backend_assets/js/ckeditor.js') }}"></script>

<script src="{{ asset('backend_assets/js/ckeditor_custom.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr("#news_date", {
                    defaultDate: new Date(), // Sets the default date to the current date
                    dateFormat: "Y-m-d", // Adjust the date format if needed
                });
            
            });
        </script>
        
@endpush
