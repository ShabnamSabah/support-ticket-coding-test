@extends('backend.customer.includes.customer_layout')
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" mb-2" style="text-align:center">
                            <h3>Ticket Response List</h3>
                        </div>
                        <div class="mt-3">
                            @if (session('error'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Failed!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="btn-close"></button>
                                </div>
                            @endif
                            <div id="success"></div>
                            <div id="failed"></div>
                        </div>
                        <div class="table-responsive" id="print_data">
                            <table id="dataTableExample" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="">SL</th>
                                        <th>Issue Date</th>
                                        <th style="">Description</th>
    
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['ticket_response_list'] as $key => $single_ticket)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                          
                                            <td>
                                                {{  date('d F Y', strtotime($single_ticket->issue_date)) }} 
                                            </td>
                                            <td>
                                                {{  $single_ticket->description}} 
                                            </td>
                                          
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    
@endpush
