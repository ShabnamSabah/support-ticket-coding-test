<?php

namespace App\Http\Controllers\backend\admin;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use PDOException;

class CustomerController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function customer_add(Request $request)
    {
        $data = [];
        if ($request->isMethod('post')) {


            try {
               $customer= User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'user_type' => 'customer',
                    'tagline' => $request->tagline,
                     'introduction'=>$request->introduction,

                ]);

                $photo = $request->file('photo');
                if ($photo) {
                   
                    $photo_name = 'backend_assets/images/user/'. $customer->id . '.jpg';
                    $image = Image::make($photo);
                    $image->resize(403, 480);
                    $image->save($photo_name);
                } else {
                    $photo_name = null;
                }
               $customer->photo = $photo_name;
               $customer->save();
                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again' . $e->getMessage());
            }

     }

        $data['active_menu'] = 'customer_add';
        $data['page_title'] = 'Customer Add';
        return view('backend.admin.pages.customer_add', compact('data'));
    }
    public function customer_edit(Request $request, $id)
    {
        $data = [];
        $data['customer'] = User::find($id);
        if ($data['customer'] != null) {
            if ($request->isMethod('post')) {
                $old_photo = $data['customer']->photo;
                $photo = $request->file('photo');
                if ($photo) {

                    if (File::exists($old_photo)) {
                        File::delete($old_photo);
                    }
                   
                    $photo_name = 'backend_assets/images/user/'. $data['customer']->id. '.jpg' ;
                    $image = Image::make($photo);
                    $image->resize(403, 480);
                    $image->save($photo_name);
                    
                } else {
                    $photo_name = $old_photo;
                }
                if ($request->password) {
                    $password = bcrypt($request->password);
                } else {
                    $password = $data['customer']->password;
                }

                try {
                    $data['customer']->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => $password,
                        'photo' => $photo_name,
                        'user_type' => 'customer',
                        'tagline' => $request->tagline,
                        'introduction'=>$request->introduction,

                    ]);
                    return back()->with('success', 'Updated Successfully');
                } catch (PDOException $e) {
                    return back()->with('error', 'Failed Please Try Again');
                }
              }
            } else {
                return redirect()->route('admin.customer.list')->with('error', 'Wrong Attempt.');
            }
      
        $data['active_menu'] = 'customer_edit';
        $data['page_title'] = 'Customer Edit';
        return view('backend.admin.pages.customer_edit', compact('data'));
    }

    
    public function customer_list()
    {
        $data = [];
        $data['customer_list'] = DB::table('users')->where('user_type', 'customer')->select('id', 'name', 'email', 'photo', 'phone')->orderByDesc('id')->get();
        $data['active_menu'] = 'customer_list';
        $data['page_title'] = 'Customer List';
        return view('backend.admin.pages.customer_list', compact('data'));
    }

    public function customer_delete($id)
    {
        $server_response = ['status' => 'FAILED', 'message' => 'Not Found'];
        $customer = User::find($id);
        if ($customer) {
            if (File::exists($customer->photo)) {
                File::delete($customer->photo);
            }
            $customer->delete();
            $server_response = ['status' => 'SUCCESS', 'message' => 'Deleted Successfully'];
        } else {
            $server_response = ['status' => 'FAILED', 'message' => 'Not Found'];
        }
        echo json_encode($server_response);
    }
}
