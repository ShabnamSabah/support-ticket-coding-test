<?php

namespace App\Http\Controllers\backend\customer;

use App\Http\Controllers\Controller;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Http\Middleware\CustomerAuthenticationMiddleware;
use App\Mail\TicketCloseEmail;
use App\Mail\TicketIssueEmail;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDOException;

class TicketController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            BackendAuthenticationMiddleware::class,
            CustomerAuthenticationMiddleware::class
        ];
    }

    public function ticket_add(Request $request)
    {
        $data = [];
        $admin = DB::table('users')->where('user_type','admin')->first();
        if ($request->isMethod('post')) {
            //dd($request->all());
       
            try {
               $ticket= Ticket::create([
                    'name' => $request->name,
                    'issue_date' =>date('Y-m-d', strtotime($request->issue_date)),
                    'description' => $request->description,
                    'created_by' => Auth::user()->id,
                   
                ]);
              
                $senderEmail=Auth::user()->email;
                $senderName= Auth::user()->name;
                $receiverEmail=$admin->email;
                $receiverName= $admin->name;
                $msg= $ticket->description;
                $subject= "New Ticket Named ". $ticket->name. " From ".  $senderName;

                
                Mail::to($receiverEmail)->send(new TicketIssueEmail($msg, $subject, $senderEmail, $senderName, $receiverName));

              
                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again'. $e);
            }
        }
    
        $data['active_menu'] = 'ticket_add';
        $data['page_title'] = 'Ticket Add';
        return view('backend.customer.pages.ticket_add', compact('data'));
    }

    public function ticket_list(Request $request)
    {

        $data=array();   
        $data['ticket_list'] = DB::table('tickets')->select('id', 'name', 'issue_date','description', 'status')->get();
        $data['active_menu'] = 'ticket_list';
        $data['page_title'] = 'Ticket List';
        return view('backend.customer.pages.ticket_list', compact('data'));
    }

    public function ticket_close(Request $request, $id)
    {
        $data = [];
        $data['ticket'] = Ticket::find($id);
        $admin = DB::table('users')->where('user_type','admin')->first();
        if( $data['ticket']!= null){
        if ($request->isMethod('post')) {
        
            try {
                $data['ticket']->update([ 
                    'status' => $request->status 
                 ]);
                 $senderEmail=Auth::user()->email;
                 $senderName= Auth::user()->name;
                 $receiverEmail=$admin->email;
                 $receiverName= $admin->name;
                 $msg=  $data['ticket']->name . 'is  Closed  By  its Customer '.  Auth::user()->name;
                 $subject= "A  Ticket Named ".  $data['ticket']->name. " is Closed";
                 Mail::to($receiverEmail)->send(new TicketCloseEmail($msg, $subject, $senderEmail, $senderName, $receiverName));
     
                 
                return back()->with('success', 'Updated Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }
    }else{
        return redirect()->route('customer.ticket.list')->with('error', 'Wrong Attempt!');
    }
    $data['active_menu'] = 'ticket_close';
    $data['page_title'] = 'Ticket Close';
    return view('backend.customer.pages.ticket_close', compact('data'));
}

public function ticket_response_list(Request $request, $id)
{

    $data=array();   
    $data['ticket_response_list'] = DB::table('responses')->where('ticket_id', $id)->select('id', 'issue_date','description')->get();
    $data['active_menu'] = 'ticket_list';
    $data['page_title'] = 'Ticket List';
    return view('backend.customer.pages.ticket_response_list', compact('data'));
}
}
