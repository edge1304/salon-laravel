<?php

namespace App\Http\Controllers;

use App\Components\AccoungtingEntryData;
use App\Components\FundbookData;
use App\Components\Recusive;
use App\Models\AccountingEntry;
use App\Models\Debt;
use App\Models\Fundbook;
use App\Traits\HelperTrait;
use App\Traits\PaginationPageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Payment;
class ControllerPayment extends Controller
{
    //
    use PaginationPageTrait;
    use HelperTrait;
    private $payment;
    private $accountingEntry;
    private $debt;
    private $fundbook;
    function __construct(Payment $payment, AccountingEntry $accountingEntry, Debt $debt, Fundbook $fundbook)
    {
        $this->payment = $payment;
        $this->accountingEntry = $accountingEntry;
        $this->debt = $debt;
        $this->fundbook = $fundbook;
    }
    function index(){
        $key = "";

        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];

        $fromdate = date_format(Carbon::now()->firstOfMonth(),'Y-m-d') ;
        $todate = date_format(Carbon::now(),'Y-m-d') ;
        if(isset($_GET['search'])) $key = $_GET['search'];
        if(isset($_GET['fromdate'])) $fromdate = $_GET['fromdate'];
        if(isset($_GET['todate'])) $todate = $_GET['todate'];

        $data = $this->payment
            ->where('payments.created_at','>=',$fromdate." 00:00:00")
            ->where('payments.created_at','<=',$todate. " 23:59:59")
//            ->join('customers','customers.id','=','payments.customer_id')
//            ->orwhere(function ($query)use($key){
//                $query->where('customers.name','LIKE','%'.$key.'%')
//                    ->orwhere('customers.phone','LIKE','%'.$key.'%');
//            })
//            ->select('payments.*, customers.name, customers.phone')
            ->paginate($limit)->appends(request()->query());

        foreach ($data as $item){
            $item['accounting_entry_name'] = $this->accountingEntry->find($item['accounting_entry_id'])['accounting_entry_name'];
            $item['fundbook_name'] = $this->fundbook->find($item['fundbook_id'])['fundbook_name'];
        }


        return view("admin.payment.index",compact('data','limit','key', 'page','fromdate','todate'));
    }

    function  create(){
        $fundbookData = new FundbookData();
        $accoutingData = new AccoungtingEntryData();
        $htmlFundbook = $fundbookData->getHtmlFundbook();
        $htmlAccounting = $accoutingData->getHtmlAccoungting('payment');
        return view('admin.payment.add', compact('htmlFundbook','htmlAccounting'));
    }

    function insert(Request  $request){
        try{
            DB::beginTransaction();

            $request->validate([
                'customer_id' => 'required',
                'fundbook_id' => 'required',
                'accounting_entry_id' => 'required',
                'money' => 'required',
            ]);

            $user_id = auth()->id();
            $note = $request['note'];
            $fundbook_id = $request['fundbook_id'];
            $customer_id = $request['customer_id'];
            $accounting_entry_id = $request['accounting_entry_id'];
            $money = $this->tryParseInt($request['money']);
            if($money <= 0) return redirect()->route('admin.payment.add')->with('error','Tổng tiền phải lớn hơn 0!');

            $data_accounting = $this->accountingEntry->find($accounting_entry_id);

            $insert_payment = $this->payment->create([
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'money' => $money,
                'fundbook_id' =>$fundbook_id,
                'accoungting_entry_id' =>$accounting_entry_id,
                'is_debt' =>$data_accounting['is_cost'],
                'note' => $note
            ]);

            if($data_accounting['is_cost']){
                $this->debt->create([
                    'customer_id' => $customer_id,
                    'user_id' => $user_id,
                    'payment' => $money,
                    'note' => $note,
                    'debt_type' => 'payment',
                    'from_id' => $insert_payment['id']
                ]);
            }
            DB::commit();
            return redirect()->route('admin.payment.index')->with('success','Thêm mới thành công!');
        }
        catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
            return redirect()->route('admin.payment.add')->with('error','Có lỗi xảy ra !');
        }

    }
    function  edit($id){


    }

    function update($id,Request  $request){

    }
    function  delete($id){

    }

}
