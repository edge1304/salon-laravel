<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Traits\HelperTrait;
use App\Traits\PaginationPageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ControllerUser extends Controller
{
    //
    use PaginationPageTrait;
    private  $user;

    function __construct(User $user)
    {
       $this->user = $user;
    }
    public function loginAdmin(){

       if(auth()->check()){
            return view('admin.home');
        }

        return redirect()->route('login');
    }
    public function check_tab_login(){
        if(auth()->check()){
            return redirect()->route('home');
        }
        return view('admin.login.index');
    }
    public function postLoginAdmin(Request $request){

        $remember = $request->has('remember_me') ? true : false;
        if(auth()->attempt([
            'phone'=>$request->username,
            'password'=>$request->password,
        ],$remember)){
            return redirect()->route('home');
        }
        else{
            return redirect()->route('login')->with('error','Tên đăng nhập hoặc mật khẩu không chính xác');
        }

    }

    public function logout() {
        Auth::logout();
        return redirect('/dang-nhap');
    }

    function index(){

        $key = "";
        if(isset($_GET['ten-nhan-vien'])) $key = $_GET['ten-nhan-vien'];
        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];

        $users= $this->user->where('name','LIKE','%'.$key.'%')->paginate($limit)->appends(request()->query());
        return view("admin.user.index",compact('users','limit','key', 'page'));
    }
    function  create(){
        $this->middleware('auth');
        return view('admin.user.add');
    }
    function insert(Request $request){

        try{
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
            ]);

            $data_create = [
                'name' => trim($request->name),
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ];
            if(!empty($request->password)){
                $data_create['password'] = bcrypt($request->password);
            }
            $this->user->create($data_create);
            return redirect()->route('admin.user.index')->with('success','Thêm mới nhân viên thành công');
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.user.add')->with('error','Số điện thoại đã tồn tại');
        }

    }

    function edit ($id){
        $user = $this->user->find($id);
        return view('admin.user.edit',compact('user'));
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

            if(!empty($request->password)){
                $data_update['password'] = bcrypt($request->password);
            }
            $this->user->find($id)->update($data_update);
            return redirect()->route('admin.user.index')->with('success','Chỉnh sửa nhân viên thành công');
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.user.add')->with('error','Số điện thoại đã tồn tại');
        }

    }

    function delete ($id){
        $this->user->find($id)->delete();
        return  redirect()->route('admin.user.index')->with('success','xóa thành công');
    }
    function  findOther(){

        $key = "";
        if(isset($_GET['search'])) $key = $_GET['search'];
        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];

        $users= $this->user->orwhere( function ($query )use($key){
            $query->where('name','LIKE','%'.$key.'%')
                ->orwhere('phone','LIKE','%'.$key.'%');
        })->offset($page-1)->limit($limit)->get();
        return $users;

    }

}

