<?php

namespace App\Components;
use Illuminate\Support\Facades\Log;

class Recusive
{

    private $data;
    private $htmlSelect = '';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function categoryRecusive($id_parent = null, $id = 0, $text = '')
    {

        foreach ($this->data as $category) {
            if ($category->id_parent == $id) {
                $isSelected = "";
                if(!empty($id_parent) && $id_parent == $category->id){
                    $isSelected = "selected";
                }
                $this->htmlSelect .= "<option $isSelected value=" . $category->id . ">" . $text . $category->category_name . "</option>";
                $this->categoryRecusive($id_parent,$category->id, $text . '--');
            }
        }
        return $this->htmlSelect;
    }
    public function categoryRecusiveProduct($id_parent = null, $id = 0, $text = '')
    {
        foreach ($this->data as $category) {
            if ($category->id_parent == $id) {
                $isSelected = "";
                if(!empty($id_parent) && $id_parent == $category->id){
                    $isSelected = "selected";
                }
                $this->htmlSelect .= "<option $isSelected value=" . $category->id . ">" . $text . $category->category_name . "</option>";
                $this->categoryRecusive($id_parent,$category->id, $text . '--');
            }
        }
        return $this->htmlSelect;
    }
}
