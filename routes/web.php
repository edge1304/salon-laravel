<?php


use Illuminate\Support\Facades\Route;



Route::get('/', 'ControllerUser@loginAdmin')->name('home');
Route::post('/', 'ControllerUser@postLoginAdmin');
Route::get('/dang-nhap', 'ControllerUser@check_tab_login')->name("login");
Route::get('/dang-xuat', 'ControllerUser@logout')->name('logout');
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::prefix('/danh-muc')->group(function (){
    Route::get('/',[
       'as'=> 'admin.category.index',
       'uses'=>'ControllerCategory@index'
    ]);

    Route::get('/tao-moi',[
        'as'=> 'admin.category.add',
        'uses'=>'ControllerCategory@create'
    ]);
    Route::post('/tao-moi',[
        'as'=> 'admin.category.insert',
        'uses'=>'ControllerCategory@insert'
    ]);
    Route::get('/chinh-sua/{id}',[
        'as'=> 'admin.category.edit',
        'uses'=>'ControllerCategory@edit'
    ]);
    Route::post('/chinh-sua/{id}',[
        'as'=> 'admin.category.update',
        'uses'=>'ControllerCategory@update'
    ]);
    Route::get('/xoa/{id}',[
        'as'=> 'admin.category.delete',
        'uses'=>'ControllerCategory@delete'
    ]);
});

Route::prefix('/san-pham')->group(function (){
    Route::get('/',[
        'as'=> 'admin.product.index',
        'uses'=>'ControllerProduct@index'
    ]);
    Route::get('/find-other',[
        'as'=> 'admin.product.findOther',
        'uses'=>'ControllerProduct@findOther'
    ]);
    Route::get('/tao-moi',[
        'as'=> 'admin.product.add',
        'uses'=>'ControllerProduct@create'
    ]);
    Route::post('/tao-moi',[
        'as'=> 'admin.product.insert',
        'uses'=>'ControllerProduct@insert'
    ]);
    Route::get('/chinh-sua/{id}',[
        'as'=> 'admin.product.edit',
        'uses'=>'ControllerProduct@edit'
    ]);
    Route::post('/chinh-sua/{id}',[
        'as'=> 'admin.product.update',
        'uses'=>'ControllerProduct@update'
    ]);
});
Route::middleware('auth')->prefix('/nhan-vien')->group(function (){
    Route::get('/',[
        'as'=> 'admin.user.index',
        'uses'=>'ControllerUser@index'
    ]);
    Route::get('/find-other',[
        'as'=> 'admin.user.findOther',
        'uses'=>'ControllerUser@findOther'
    ]);
    Route::get('/tao-moi',[
        'as'=> 'admin.user.add',
        'uses'=>'ControllerUser@create'
    ]);
    Route::post('/tao-moi',[
        'as'=> 'admin.user.insert',
        'uses'=>'ControllerUser@insert'
    ]);
    Route::get('/chinh-sua/{id}',[
        'as'=> 'admin.user.edit',
        'uses'=>'ControllerUser@edit'
    ]);
    Route::post('/chinh-sua/{id}',[
        'as'=> 'admin.user.update',
        'uses'=>'ControllerUser@update'
    ]);
    Route::get('/xoa/{id}',[
        'as'=> 'admin.user.delete',
        'uses'=>'ControllerUser@delete'
    ]);
});
Route::middleware('auth')->prefix('/khach-hang')->group(function (){
    Route::get('/',[
        'as'=> 'admin.customer.index',
        'uses'=>'ControllerCustomer@index'
    ]);
    Route::get('/find-other',[
        'as'=> 'admin.customer.findOther',
        'uses'=>'ControllerCustomer@findOther'
    ]);
    Route::get('/tao-moi',[
        'as'=> 'admin.customer.add',
        'uses'=>'ControllerCustomer@create'
    ]);
    Route::post('/tao-moi-api',[
        'as'=> 'admin.customer.insert_api',
        'uses'=>'ControllerCustomer@insert_from_api'
    ]);
    Route::post('/tao-moi',[
        'as'=> 'admin.customer.insert',
        'uses'=>'ControllerCustomer@insert'
    ]);
    Route::get('/chinh-sua/{id}',[
        'as'=> 'admin.customer.edit',
        'uses'=>'ControllerCustomer@edit'
    ]);
    Route::post('/chinh-sua/{id}',[
        'as'=> 'admin.customer.update',
        'uses'=>'ControllerCustomer@update'
    ]);

});


Route::middleware('auth')->prefix('/so-quy')->group(function (){
    Route::get('/',[
        'as'=> 'admin.fundbook.index',
        'uses'=>'ControllerFundBook@index'
    ]);
    Route::get('/tao-moi',[
        'as'=> 'admin.fundbook.add',
        'uses'=>'ControllerFundBook@create'
    ]);
    Route::post('/tao-moi',[
        'as'=> 'admin.fundbook.insert',
        'uses'=>'ControllerFundBook@insert'
    ]);
    Route::get('/chinh-sua/{id}',[
        'as'=> 'admin.fundbook.edit',
        'uses'=>'ControllerFundBook@edit'
    ]);
    Route::post('/chinh-sua/{id}',[
        'as'=> 'admin.fundbook.update',
        'uses'=>'ControllerFundBook@update'
    ]);

});
Route::middleware('auth')->prefix('/xuat-hang')->group(function (){
    Route::get('/',[
        'as'=> 'admin.formexport.index',
        'uses'=>'ControllerExport@index'
    ]);
    Route::get('/chi-tiet/{id}',[
        'as'=> 'admin.formexport.detail',
        'uses'=>'ControllerExport@info_detail'
    ]);
    Route::get('/tao-moi',[
        'as'=> 'admin.formexport.add',
        'uses'=>'ControllerExport@create'
    ]);

    Route::post('/tao-moi',[
        'as'=> 'admin.formexport.insert',
        'uses'=>'ControllerExport@insert'
    ]);
    Route::get('/in-phieu/{id}',[
        'as'=> 'admin.formexport.print',
        'uses'=>'ControllerExport@print'
    ]);
    Route::get('/chinh-sua/{id}',[
        'as'=> 'admin.formexport.edit',
        'uses'=>'ControllerExport@edit'
    ]);
    Route::delete('/',[
        'as'=> 'admin.formexport.delete',
        'uses'=>'ControllerExport@delete'
    ]);
});
Route::middleware('auth')->prefix('/phieu-chi')->group(function () {
    Route::get('/', [
        'as' => 'admin.payment.index',
        'uses' => 'ControllerPayment@index'
    ]);

    Route::get('/them-moi', [
        'as' => 'admin.payment.add',
        'uses' => 'ControllerPayment@create'
    ]);

    Route::post('/insert', [
        'as' => 'admin.payment.insert',
        'uses' => 'ControllerPayment@insert'
    ]);
});
Route::prefix('/but-toan-thu-chi')->group(function (){
    Route::get('/',[
        'as'=> 'admin.accounting_entry.index',
        'uses'=>'ControllerAccounting_Entry@index'
    ]);

    Route::get('/tao-moi',[
        'as'=> 'admin.accounting_entry.add',
        'uses'=>'ControllerAccounting_Entry@create'
    ]);
    Route::post('/tao-moi',[
        'as'=> 'admin.accounting_entry.insert',
        'uses'=>'ControllerAccounting_Entry@insert'
    ]);
    Route::get('/chinh-sua/{id}',[
        'as'=> 'admin.accounting_entry.edit',
        'uses'=>'ControllerAccounting_Entry@edit'
    ]);
    Route::post('/chinh-sua/{id}',[
        'as'=> 'admin.accounting_entry.update',
        'uses'=>'ControllerAccounting_Entry@update'
    ]);

});
