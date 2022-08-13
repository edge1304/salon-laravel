<?php

namespace App\Http\Controllers;

use App\Models\Fundbook;
use App\Traits\PaginationPageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ControllerFundBook extends Controller
{
    use PaginationPageTrait;
    //
    private $fundbook;
    function __construct(Fundbook $fundbook)
    {
        $this->fundbook = $fundbook;
    }
    function index(){

        $key = "";
        if(isset($_GET['search'])) $key = $_GET['search'];

        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];

        $fundbooks = $this->fundbook->where('fundbook_name','LIKE','%'.$key.'%')->paginate($limit)->appends(request()->query());
        return view("admin.fundbook.index",compact('fundbooks','limit','key', 'page'));
    }
    function  create(){
        $html_type = $this->getHtmlType();
        return view('admin.fundbook.add', compact('html_type'));
    }
    function insert(Request $request){

        try{
            $request->validate([
                'fundbook_name' => 'required',
                'fundbook_type'=>'required'
            ]);

            $data_create = [
                'fundbook_name' => trim($request->fundbook_name),
                'fundbook_type' => $request->fundbook_type,

            ];

            $this->fundbook->create($data_create);
            return redirect()->route('admin.fundbook.index')->with('success','Thêm mới thành công');
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.fundbook.add')->with('error','Có lỗi xảy ra');
        }

    }

    function edit ($id){
        $fundbook = $this->fundbook->find($id);
        $html_type = $this->getHtmlType($fundbook->fundbook_type);
        return view('admin.fundbook.edit',compact('fundbook','html_type'));
    }
    function update($id,Request $request){

        try{
            $request->validate([
                'fundbook_name' => 'required',
                'fundbook_type'=>'required'
            ]);

            $data_update = [
                'fundbook_name' => trim($request->fundbook_name),
                'fundbook_type' => $request->fundbook_type,

            ];

            $this->fundbook->find($id)->update($data_update);
            return redirect()->route('admin.fundbook.index')->with('success','Chỉnh sửa thành công');
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.fundbook.add')->with('error','Thất bại, có lỗi xả ra');
        }

    }

    function getHtmlType($type = null){
        $types = ['Tiền mặt','Ngân hàng','Khác'];
        $html = '';
        foreach ($types as $item){
            $isSelected = "";
            if($item == $type) $isSelected = "selected";
            $html .= "<option $isSelected value='$item'>".$item. "</option>";
        }
        return $html;
    }
}
