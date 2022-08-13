<?php

namespace App\Components;

use App\Models\AccountingEntry;

class AccoungtingEntryData
{
    private $htmlAccounting;

    function getHtmlAccoungting($type){
        $this->htmlAccounting = '';
        $data = AccountingEntry::where('accounting_entry_type',$type)->get();

        foreach ($data as $item){
            $this->htmlAccounting .= "<option value=".$item->id.">". $item->accounting_entry_name . "</option>";
        }
        return $this->htmlAccounting;
    }
}
