@extends('backend.admin.includes.admin_layout')
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h6 class="card-title mb-3">Welcome To Dashboard</h6>
               <div class="row">
                <div class="card">
                    <div class="card-body">
                   

                            <div class="table-responsive" id="print_data">
                                <table id="dataTableExample" class="table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="">SL</th>
                                           
                                            <th style="">Name</th>
                                            <th style="">Issue Date</th>
                                            <th style="">Description</th>
                                          <th>Created By</th>
                                            <th style="width:15%">action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['ticket_list'] as $key => $single_ticket)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                              
                                                <td>
                                                    {{  $single_ticket->name }} <br>
                                                    @if( $single_ticket->status == 1 )
                                                    <span class="badge bg-success">Open</span>
                                                    @else
                                                    <span class="badge bg-danger">Closed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{  date('d F Y', strtotime($single_ticket->issue_date)) }} 
                                                </td>
                                                <td>
                                                    {{  $single_ticket->description}} 

                                                </td>
                                                <td>
                                                    {{  $single_ticket->created_by}} 
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.ticket.response.list', $single_ticket->id) }}"
                                                        class="btn btn-info btn-icon" href=""><i
                                                            class="fa-solid fa-eye"></i></a>
    
                                                    <a href="{{route('admin.ticket.response', $single_ticket->id)}}"
                                                        class="btn btn-success btn-icon" href=""><i
                                                            class="fa-solid fa-reply"></i></a>
                                                  
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
    </div>
@endsection
