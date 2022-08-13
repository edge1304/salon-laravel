<?php

namespace App\Http\Controllers;

use App\Models\AccountingEntry;
use App\Traits\PaginationPageTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class ControllerAccounting_Entry extends Controller
{
    //
    use UploadImageTrait;
    use PaginationPageTrait;

    function __construct(AccountingEntry  $accountingEntry)
    {
        $this->accountingEntry = $accountingEntry;
    }
    function index(){
        $key = "";
        if(isset($_GET['search'])) $key = $_GET['search'];
        $pagination = $this->pagination();
        $limit = $pagination['limit'];
        $page = $pagination['page'];
        $accounting_entry_type = "";
        if(isset($_GET['accounting_entry_type'])) $accounting_entry_type = $_GET['accounting_entry_type'];

        $data = $this->accountingEntry
            ->where('accounting_entry_name','LIKE','%'.$key.'%')
            ->where('accounting_entry_type','LIKE','%'.$accounting_entry_type.'%')
            ->paginate($limit)->appends(request()->query());
        $html_type = $this->get_html_type_accounting($accounting_entry_type);
        return view("admin.accounting_entry.index",compact('data','limit','key', 'page','html_type'));
    }

    function get_html_type_accounting($type = ""){

        $select1 = $type == ""?"selected":"";
        $select2 = $type == "receive"?"selected":"";
        $select3 = $type == "payment"?"selected":"";
        $html =
            "<option ".$select1." value=''>Tất cả</option>".
            "<option ".$select2." value='receive'>Thu</option>".
            "<option ".$select3." value='payment'>Chi</option>";
        return $html;

    }
}
