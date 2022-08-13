<?php
namespace App\Traits;

trait PaginationPageTrait{

    public function pagination(){
        $limit = 10;
        if(isset($_GET['limit'])) $limit = $_GET['limit'];
        $page = 1;
        if(isset($_GET['page'])) $page = $_GET['page'];
        return [
            'limit' => $limit,
            'page' => $page
        ];
    }
}
?>
