<?php

namespace App\Components;

use App\Models\Fundbook;

class FundbookData
{
    private $htmlFundbook;

    function getHtmlFundbook(){
        $this->htmlFundbook = '';
        $data = Fundbook::all();

        foreach ($data as $item){
            $this->htmlFundbook .= "<option value=".$item->id.">". $item->fundbook_name . "</option>";
        }
        return $this->htmlFundbook;
    }
}
