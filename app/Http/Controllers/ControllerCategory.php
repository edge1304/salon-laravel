<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Category;
use App\Traits\PaginationPageTrait;
use App\Traits\UploadImageTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ControllerCategory extends Controller
{
    use UploadImageTrait;
    use PaginationPageTrait;
    function __construct(Category  $category)
    {
        $this->middleware('auth');
        $this->category = $category;
    }

    function index(){
        $key = "";
        if(isset($_GET['ten-danh-muc'])) $key = $_GET['ten-danh-muc'];
        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];
        $categories = $this->category->where('category_name','LIKE','%'.$key.'%')->paginate($limit)->appends(request()->query());
        return view("admin.category.index",compact('categories','limit','key', 'page'));
    }

    function  create(){
        $html_option_category = $this->getHtmlCategory();
        return view('admin.category.add',compact('html_option_category'));
    }

    function insert(Request  $request){
        $dataFile = $this->updateFileOneImage($request,'image','public/images/cateogry');
        $image_name = $dataFile?$dataFile['final_name']:"";

        $data_new_category = [
            'category_name'=> $request->category_name,
            'id_parent' => $request->id_parent,
            'category_image'=> $image_name,
            'category_slug' => Str::slug($request->category_name),
            'category_image_link' => $dataFile?$dataFile['file_path']:""
        ];
        $this->category->create($data_new_category);
        return redirect()->route('admin.category.index');
    }
    function  edit($id){

        $category = $this->category->find($id);
        $html_option_category = $this->getHtmlCategory($category->id_parent);
        return view('admin.category.edit', compact('category','html_option_category'));
    }

    function update($id,Request  $request){
        $dataFile = $this->updateFileOneImage($request,'image','public/images/cateogry');
        $image_name = $dataFile?$dataFile['final_name']:"";

        $data_new_category = [
            'category_name'=> $request->category_name,
            'id_parent' => $request->id_parent,
            'category_slug' => Str::slug($request->category_name),
        ];
        if($dataFile){
            $data_new_category['category_image'] = $image_name;
            $data_new_category['category_image_link'] = $dataFile['file_path'];
        }
        $this->category->find($id)->update($data_new_category);
        return redirect()->route('admin.category.index');
    }
    function  delete($id){
        $this->category->find($id)->delete();
        return redirect()->route('admin.category.index');
    }

    public  function  getHtmlCategory($id_parent = null){
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $html_option_category = $recusive->categoryRecusive($id_parent);
        return $html_option_category;
    }
}


