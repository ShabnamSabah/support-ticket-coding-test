<?php

namespace App\Http\Controllers\backend\admin;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Mail\TicketResponseEmail;
use App\Models\Response;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use PDOException;

class DashboardController extends Controller implements HasMiddleware
{

  public static function middleware(): array
  {
    return [
      BackendAuthenticationMiddleware::class,
      AdminAuthenticationMiddleware::class
    ];
  }

  public function dashboard()
  {
    $data = array();

        $data=array();   
        $data['ticket_list'] = DB::table('tickets')
        ->leftJoin('users', 'users.id', '=', 'tickets.created_by')
        ->where('tickets.status', 1)
        ->select('tickets.id', 'tickets.name', 'tickets.issue_date','tickets.description', 'tickets.status', 'users.name as created_by')->get();
        $data['active_menu'] = 'dashboard';
        $data['page_title'] = 'Dashboard';
        return view('backend.admin.pages.dashboard', compact('data'));
    }

    public function ticket_response(Request $request, $id)
    {
        $data = array();
        $data['ticket'] = Ticket::find($id);
        if ($request->isMethod('post')) {
            //dd($request->all());
       
       $customer = DB::table('users')->where('id', $data['ticket']->created_by)->first();
            try {
               $response= Response::create([
                    'ticket_id' =>   $data['ticket']->id,
                    'issue_date' =>date('Y-m-d', strtotime($request->issue_date)),
                    'description' => $request->description,
                    'created_by' => Auth::user()->id,
                   
                ]);
                $senderEmail= Auth::user()->email;
                $senderName= Auth::user()->name;
                $receiverEmail=$customer->email;
                $receiverName = $customer->name;
                $msg= $response->description;
                $subject= "New Response For ".  $data['ticket']->name. " From ".  Auth::user()->name;
                Mail::to($receiverEmail)->send(new TicketResponseEmail($msg, $subject, $senderEmail, $senderName, $receiverName));

                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again'. $e);
            }
        }
       
        $data['active_menu'] = 'response_add';
        $data['page_title'] = 'Response Add';
        return view('backend.admin.pages.response_add', compact('data'));
    }


    public function ticket_response_list(Request $request, $id)
    {
    
        $data=array();   
        $data['ticket_response_list'] = DB::table('responses')->where('ticket_id', $id)->select('id', 'issue_date','description')->get();
        $data['active_menu'] = 'ticket_list';
        $data['page_title'] = 'Ticket List';
        return view('backend.admin.pages.ticket_response_list', compact('data'));
    }
}
