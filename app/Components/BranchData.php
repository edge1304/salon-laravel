<?php

namespace App\Components;

use App\Models\Branch;

class BranchData
{
    private $data;
    private $htmlBranch = '';

    public function __construct(){

    }
    public function branchHtml(){
        $data = Branch::all();
        foreach($data as $branch){
            $this->htmlBranch .= '<option value=".$branch->id.">'.$branch->branch_name.'</option>';
        }
        return $this->htmlBranch;
    }
}
