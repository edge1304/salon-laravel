<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\PaginationPageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ControllerCustomer extends Controller
{
    //
    use PaginationPageTrait;
    private  $customer;

    function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
    function index(){

        $key = "";
        if(isset($_GET['search'])) $key = $_GET['search'];
        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];

        $customers= $this->customer->orwhere( function ($query )use($key){
            $query->where('name','LIKE','%'.$key.'%')
                ->orwhere('phone','LIKE','%'.$key.'%');
        })->paginate($limit)->appends(request()->query());
        return view("admin.customer.index",compact('customers','limit','key', 'page'));
    }
    function  create(){
        return view('admin.customer.add');
    }
    function insert(Request $request){

        try{
            $request->validate([
                'name' => 'required',
            ]);

            $data_create = [
                'name' => trim($request->name),
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ];

            $this->customer->create($data_create);
            return redirect()->route('admin.customer.index')->with('success','Thêm mới khách hàng thành công');
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.customer.add')->with('error','Có lỗi xảy ra');
        }

    }
    function insert_from_api(Request $request){

        try{
            $request->validate([
                'name' => 'required',
            ]);

            $data_create = [
                'name' => trim($request->name),
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ];

            $data_insert = $this->customer->create($data_create);
            return \response()->json([
                'data' =>$data_insert,
                'message' => 'success'
            ],200) ;
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.customer.add')->with('error','Có lỗi xảy ra');
        }

    }
    function edit ($id){
        $customer = $this->customer->find($id);
        return view('admin.customer.edit',compact('customer'));
    }
    function update($id,Request $request){

        try{
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
            ]);

            $data_update = [
                'name' => trim($request->name),
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ];

            $this->customer->find($id)->update($data_update);
            return redirect()->route('admin.customer.index')->with('success','Chỉnh sửa khách hàng thành công');
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.customer.add')->with('error','Thất bại, có lỗi xả ra');
        }

    }

    function  findOther(){

        $key = "";
        if(isset($_GET['search'])) $key = $_GET['search'];
        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];

        $customers= $this->customer->orwhere( function ($query )use($key){
            $query->where('name','LIKE','%'.$key.'%')
                ->orwhere('phone','LIKE','%'.$key.'%');
        })->offset($page-1)->limit($limit)->get();
        return $customers;
    }
}
