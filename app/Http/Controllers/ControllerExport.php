<?php

namespace App\Http\Controllers;

use App\Components\FundbookData;

use App\Models\Customer;
use App\Models\Debt;
use App\Models\ExportDetail;
use App\Models\FormExport;
use App\Models\Product;
use App\Models\Receive;
use App\Models\User;
use App\Traits\HelperTrait;
use App\Traits\PaginationPageTrait;
use App\Traits\UploadImageTrait;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ControllerExport extends Controller
{
    //
    use UploadImageTrait;
    use HelperTrait;
    use PaginationPageTrait;
    private $formExport;
    private $exportDetail;
    private $debt;
    private $receive;
    private $customer;

    function __construct(FormExport $formExport, Debt $debt, ExportDetail $exportDetail, Receive $receive, Customer $customer)
    {
        $this->formExport = $formExport;
        $this->debt = $debt;
        $this->exportDetail = $exportDetail;
        $this->receive = $receive;
        $this->customer = $customer;

    }
    function index(){

        $fromdate = date_format(Carbon::now()->firstOfMonth(),'Y-m-d') ;
        $todate = date_format(Carbon::now(),'Y-m-d') ;
        $key = "";
        if(isset($_GET['search'])) $key = $_GET['search'];
        if(isset($_GET['fromdate'])) $fromdate = $_GET['fromdate'];
        if(isset($_GET['todate'])) $todate = $_GET['todate'];
        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];
        $formExports = $this->formExport->where('form_exports.created_at','>=',$fromdate." 00:00:00")
                                        ->where('form_exports.created_at','<=',$todate. " 23:59:59")
                                        ->join('customers','customers.id','=','form_exports.customer_id')
                                        ->orwhere(function ($query)use($key){
                                            $query->where('customers.name','LIKE','%'.$key.'%')
                                                ->orwhere('customers.phone','LIKE','%'.$key.'%');
                                        })->select('form_exports.*','customers.name','customers.phone')->latest()
                                        ->paginate($limit)->appends(request()->query());
        foreach ($formExports as $item){
            $item['details'] = $this->exportDetail->where('form_export_id',$item['id'])->get();
            $item['total_money'] = 0;
            foreach ($item['details'] as $item_detail){
                $item['total_money'] += $this->calculate_money($item_detail['price'], $item_detail['vat'], $item_detail['ck'], $item_detail['discount'], $item_detail['quantity']);
                $name_product = Product::find($item_detail['product_id']);
                $item_detail['product_name'] = $name_product['product_name'];
            }
        }
//
//        return \response()->json($formExports);
        return view("admin.formexport.index",compact('formExports','limit','key', 'page','fromdate','todate'));
    }

    function  create(){
        $fundbookData = new FundbookData();
        $htmlFundbook = $fundbookData->getHtmlFundbook();
        return view('admin.formexport.add', compact('htmlFundbook'));
    }
    function  insert(Request $request){
        try{
            DB::beginTransaction();
            $id_employee_auth = auth()->id();
            $data = json_decode($request->data,true);
            $array_product = $data['array_product'];

            $note = $data['note'];
            $paid = $data['paid'];
            $fundbook_id = $data['fundbook_id'];
            $customer_id = $data['customer_id'];
            if($fundbook_id == 0)
                    return \response()->json([
                    'data' =>null,
                    'message' => 'Thất bại! Sổ quỹ không được để trống'
                ],200) ;
//
            $export_insert = $this->formExport->create([
                'customer_id'=>$customer_id,
                'note'=>$note
            ]);

            $total = 0;
            foreach ($array_product as $item) {
                $total += $this->calculate_money($item['price'], $item['vat'], $item['ck'], $item['discount'], $item['quantity']);
                $detail_item = [
                    'product_id' => $item['product_id'],
                    'price' => $item['price'],
                    'vat' => $item['vat'],
                    'ck' => $item['ck'],
                    'discount' => $item['discount'],
                    'quantity' => $item['quantity'],

                ];
                if (!empty($item['employee_id'])) {
                    $detail_item['user_id'] = $item['employee_id'];
                }
                if (!empty($item['employee_id2'])) {
                    $detail_item['user_id2'] = $item['employee_id2'];
                }
                $export_insert->details()->create($detail_item);
            }
            $this->debt->create([
                'user_id'=>$id_employee_auth,
                'from_id'=> $export_insert['id'],
                'note' => $note,
                'customer_id' => $customer_id,
                'must_receive' => $total,
                'receive'=> $paid,
                'debt_type' => 'export'
            ]);

            if($paid > 0){
                $this->receive->create([
                    'user_id'=>$id_employee_auth,
                    'customer_id' => $customer_id,
                    'form_export_id' => $export_insert['id'],
                    'money' => $paid,
                    'fundbook_id' =>$fundbook_id,
                    'accounting_entry_id' => 1,
                    'note' => $note,
                    'is_debt' => true
                ]);
            }
            DB::commit();
            return \response()->json([
                'data' =>$export_insert,
                'message' => 'successfully'
            ],200) ;
        }
        catch (\Exception $exception){
            DB::rollBack();
            return \response()->json([
                'data' =>$exception,
                'message' => 'failed'
            ],400) ;
        }

    }
    function  print($id){
        $data = $this->formExport->find($id);
        $data['fundbook_name'] = "";
        $data['receive_money'] = 0;
        $data->details;
        $data['total_money'] = 0;
        $data['total_price'] = 0;
        $data['total_quantity'] = 0;
        $data['total_discount'] = 0;
        foreach ($data['details'] as $item){
            $item['name'] = $item->product['product_name'];
            $item['money'] = $this->calculate_money($item['price'], $item['vat'], $item['ck'], $item['discount'], $item['quantity']);
            $data['total_money'] += $item['money'] ;
            $data['total_price'] += $item['price'];
            $data['total_quantity'] += $item['quantity'];
            $data['total_discount'] += $item['discount'];
            $item->employee;
        }
        $data->customer;

        $receive = $this->receive->where('form_export_id',$data['id'])->first();
        if(!empty($receive)){
            $data['receive_money'] = $receive['money'];
            $data['fundbook_name'] = $receive->fundbook['fundbook_name'];
        }
        $data['text_of_money'] = $this->convert_number_to_words($data['receive_money']);
        return view('admin.formexport.print',compact('data'));
    }

    function  delete(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);
            DB::beginTransaction();
            $id = $request->id;
            $data = $this->formExport->find($id)->delete();
            $this->debt->where('from_id',$id)->where('debt_type','export')->delete();
            $this->receive->where('form_export_id',$id)->delete();
            $this->exportDetail->where('form_export_id',$id)->delete();
            DB::commit();
            return \response()->json([
                'data' =>$data,
                'message' => 'success'
            ],200) ;
        }
        catch (\Exception $exception){
            DB::rollBack();
            return \response()->json([
                'data' =>$exception,
                'message' => 'failed'
            ],400) ;
        }
    }
    function  info_detail($id){
        $data = $this->formExport->find($id);
        $data['fundbook_name'] = "";
        $data['receive_money'] = 0;
        $data->details;
        $data['total_money'] = 0;
        $data['total_price'] = 0;
        $data['total_quantity'] = 0;
        $data['total_discount'] = 0;
        foreach ($data['details'] as $item){
            $item['product_name'] = $item->product['product_name'];
            $item['money'] = $this->calculate_money($item['price'], $item['vat'], $item['ck'], $item['discount'], $item['quantity']);
            $data['total_money'] += $item['money'] ;
            $data['total_price'] += $item['price'];
            $data['total_quantity'] += $item['quantity'];
            $data['total_discount'] += $item['discount'];
            $item['employee_name1'] = "";
            $item['employee_name2'] = "";
            if(!empty($item['user_id'])){
                $item['employee_name1'] = User::find($item['user_id'])['name'];
            }
            if(!empty($item['user_id2'])){
                $item['employee_name2'] = User::find($item['user_id2'])['name'];
            }
        }
        $data->customer;

        $receive = $this->receive->where('form_export_id',$data['id'])->first();
        if(!empty($receive)){
            $data['receive_money'] = $receive['money'];
            $data['fundbook_name'] = $receive->fundbook['fundbook_name'];
        }
        $data['text_of_money'] = $this->convert_number_to_words($data['receive_money']);

        return view('admin.formexport.detail',compact('data'));
//        return \response()->json([
//            'data' =>$data,
//            'message' => 'failed'
//        ],200) ;
    }

}
