<?php

namespace App\Http\Controllers\backend\customer;


use App\Http\Controllers\Controller;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Http\Middleware\CustomerAuthenticationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller implements HasMiddleware
{

  public static function middleware(): array
  {
    return [
      BackendAuthenticationMiddleware::class,
      CustomerAuthenticationMiddleware::class
    ];
  }

  public function dashboard()
  {
    $data = array();
    $data['total_ticket'] = DB::table('tickets')->where('created_by', Auth::user()->id)->count();
    $data['active_menu'] = 'dashboard';
    $data['page_title'] = 'Dashboard';
    return view('backend.customer.pages.dashboard', compact('data'));
  }
}
