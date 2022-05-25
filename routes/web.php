<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/change_op', 'HomeController@change_op')->name('change_op');

Route::group(['middleware' => ['auth']], function() {
  Route::resource('roles','RoleController');
  Route::resource('users','UserController');
});

Route::group(['prefix' => 'Products' , 'namespace' => 'Products'] ,function()
{
    Route::get('/products','ProductsController@view_products')            ->name('view.products');
    Route::post('/Save_product','ProductsController@save_product')        ->name('save.product');
    Route::post('/Update_product','ProductsController@update_product')    ->name('update.product');
    Route::post('/Active_product','ProductsController@active_product')    ->name('active.product');
    Route::post('/Damaged_product','ProductsController@damaged_product')  ->name('damaged.product');
    Route::post('/Search_product','ProductsController@search_product')  ->name('search.product');
    Route::post('/changesale_product','ProductsController@changesale_product')  ->name('changesale.product');

    /*################################ Start Category ####################################*/
    Route::get('/Products_Category','ProductsController@view_Category') ->name('view.category');
    Route::post('/Save_category'  ,'ProductsController@save_category')    ->name('save.category');
    Route::post('/Update_category','ProductsController@update_category')->name('update.category');
    Route::post('/Delete_category','ProductsController@delete_category')->name('delete.category');
    Route::post('/Search_category','ProductsController@search_category')->name('search.category');
    Route::post('/Active_category','ProductsController@active_category')->name('active.category');
    /*################################ End Category ########################################*/

   /*################################ Start Unit ####################################*/
    Route::get('/Products_Units','ProductsController@view_unit')->name('view.unit');
    Route::post('/Save_unit','ProductsController@save_unit')    ->name('save.unit');
    Route::post('/Update_unit','ProductsController@update_unit')->name('update.unit');
    Route::post('/Delete_unit','ProductsController@delete_unit')->name('delete.unit');
    Route::post('/Search_unit','ProductsController@search_unit')->name('search.unit');
    Route::post('/Active_unit','ProductsController@active_unit')->name('active.unit');
    /*################################ End Unit ####################################*/

});

Route::group(['prefix' => 'Sales' , 'namespace' => 'Sales'] ,function()
{
  Route::get('/Sales'      ,'SalesController@view_sales')           ->name('view.sales');
  Route::post('/Search_Name','SalesController@Search_Name')         ->name('Search.Name');
  Route::post('/Item_Order','SalesController@item_order')           ->name('item_order');
  Route::post('/Order_Discount','SalesController@order_discount')   ->name('order.discount');
  Route::post('/delete_order','SalesController@delete_order')       ->name('delete_order');
  Route::post('/del_element','SalesController@del_element')         ->name('del_element');
  Route::post('/search_order','SalesController@search_order')       ->name('search_order');
  Route::post('/save_balance','SalesController@save_balance')       ->name('save_balance');
  Route::post('/transfare_to_chash','SalesController@transfare_to_chash')->name('transfare_to_chash');
  Route::post('/transfare_to_aggel','SalesController@transfare_to_aggel')->name('transfare_to_aggel');



  // Halk
  Route::get('/Halk'      ,'HalkController@view_sales')           ->name('view.halk');
  Route::post('/Search_Name_halk','HalkController@Search_Name')         ->name('Search.Name.halk');
  Route::post('/Item_Order_halk','HalkController@item_order')           ->name('item_order.halk');
  Route::post('/Order_Discount_halk','HalkController@order_discount')   ->name('order.discount.halk');
  Route::post('/delete_order_halk','HalkController@delete_order')       ->name('delete_order.halk');
  Route::post('/del_element_halk','HalkController@del_element')         ->name('del_element.halk');
  Route::post('/search_order_halk','HalkController@search_order')       ->name('search_order.halk');
  Route::post('/save_balance_halk','HalkController@save_balance')       ->name('save_balance.halk');
  Route::post('/transfare_to_chash_halk','HalkController@transfare_to_chash')->name('transfare_to_chash.halk');
  Route::post('/transfare_to_aggel_halk','HalkController@transfare_to_aggel')->name('transfare_to_aggel.halk');
});

Route::group(['prefix' => 'Reports' , 'namespace' => 'ReportsController'] ,function(){

  // Sales Reports
  Route::get('Sales_Report'      ,'SealesController@viewreport') ->name('viewreport');
  Route::post('salesreport'      ,'SealesController@sales_report') ->name('salesreport');
  Route::post('salesreportorder' ,'SealesController@sales_report_order') ->name('salesreportorder');
  // Halk Reports
  Route::get('Halk_Report'      ,'HalkController@viewreport') ->name('viewreporthalk');
  Route::post('Halkreport'      ,'HalkController@sales_report') ->name('salesreporthalk');
  Route::post('Halkreportorder' ,'HalkController@sales_report_order') ->name('salesreportorderhalk');
  // Buy Reports
  Route::get('Buy_Report'      ,'BuyController@viewreport') ->name('viewreportbuy');
  Route::post('buyreport'      ,'BuyController@buy_report') ->name('salesreportbuy');
  Route::post('buyreportorder' ,'BuyController@buy_report_order') ->name('buyreportorder');

  // Exchange Reports
  Route::get('Exchange_Report','ExchangeController@viewreport') ->name('Exchange_Report');
  Route::post('exchange_report','ExchangeController@exchange_report') ->name('exchange_report');

  // Supply_Report Reports
  Route::get('Supply_Report','ExchangeController@viewreportsupply') ->name('Supply_Report');
  Route::post('Supply_report','ExchangeController@Supply_report') ->name('Supply_report');


  // Expense_Report Reports
  Route::get('Expense_Report_view','ExpenseController@Expense_Report_view') ->name('Expense_Report_view');
  Route::post('Expense_Report','ExpenseController@Expense_Report') ->name('Expense_Report');
  

});

Route::group(['prefix' => 'Purchases' , 'namespace' => 'Purchases'] ,function()
{
  Route::get('/purchasing','PurchasesController@view_purchases')        ->name('view.purchases');
  Route::post('/Order_Buy','PurchasesController@order_buy')             ->name('order_buy');
  Route::post('/search_orderby','PurchasesController@search_order')       ->name('search_orderby');
  Route::post('/Order_DiscountBy','PurchasesController@order_discount')   ->name('Order_DiscountBy');
  Route::post('/delete_orderbuy','PurchasesController@delete_order')   ->name('delete_orderbuy');
  Route::post('/save_balancebuy','PurchasesController@save_balance')       ->name('save_balancebuy');
  Route::post('/del_elementbuy','PurchasesController@del_element')       ->name('del_elementbuy');




});

Route::group(['prefix' => 'Exchange_Supply' , 'namespace' => 'Exchange_Supply'] ,function()
{
  Route::get('/Exchange'          ,'ExchangeController@view_exchange')    ->name('view.exchange');
  Route::get('/Supply'            ,'SupplyController@view_supply')        ->name('view.supply');
  Route::post('/Save_supply'      ,'SupplyController@save_supply')        ->name('save.supply');
  Route::post('/Save_exchange'    ,'ExchangeController@save_exchange')    ->name('save.exchange');
  Route::post('/Search_supply'    ,'SupplyController@search_supply')      ->name('search.supply');
  Route::post('/Search_exchange'  ,'ExchangeController@search_exchange')  ->name('search.exchange');
  Route::post('/Delete_exchange'  ,'ExchangeController@delete_exchange')  ->name('delete.exchange');
  Route::post('/Delete_supply'    ,'SupplyController@delete_supply')      ->name('delete.supply');

});

Route::group(['prefix' => 'employees' , 'namespace' => 'Staff'] ,function()
{
  Route::get('/Staff'        ,'StaffController@view_staff')->name('view.staff');
  Route::post('/Save_staff'  ,'StaffController@save_staff')->name('save.staff');
  Route::post('/Update_staff','StaffController@update_staff')->name('update.staff');
  Route::post('/Search_staff','StaffController@search_staff')->name('search.staff');
  Route::post('/Delete_staff','StaffController@delete_staff')->name('delete.staff');
  Route::post('/Staff_payment','StaffController@staff_payment')->name('staff.payment');
  Route::post('/Change_select','StaffController@change_select')->name('change.select');
  Route::post('/Atendance'    ,'StaffController@absence_employee')->name('absence.employee');

});

Route::group(['prefix' => 'Expense' , 'namespace' => 'Expense'] ,function()
{
  Route::get('/expense','ExpenseController@view_expense')->name('view.expense');
  Route::post('/Save_expense'  ,'ExpenseController@save_expense')->name('save.expense');
  Route::post('/Delte_expense'  ,'ExpenseController@delte_expense')->name('delte.expense');
  Route::post('/Save_new_expense'  ,'ExpenseController@save_new_expense')->name('save.new.expense');
  Route::post('/Update_new_expense'  ,'ExpenseController@update_new_expense')->name('update.new.expense');
  Route::post('/Delete_sprending'  ,'ExpenseController@delete_sprending')->name('delete.sprending');
  Route::post('/Search_spending'  ,'ExpenseController@search_spending')->name('search.sprending');

});
Route::group(['prefix' => 'Setting' , 'namespace' => 'Setting'] ,function()
{
  Route::get('/Barcode','SettingController@view_barcode')           ->name('view.users');
  Route::get('/Setting','SettingController@view_setting')       ->name('view.setting');
  Route::get('/Add_job','SettingController@view_add_job')       ->name('view.add.job');
  Route::get('/Add_branch','SettingController@view_add_branch') ->name('view.add.branch');
  Route::get('/contact','SettingController@view_add_contact')   ->name('view.add.contact');
  Route::post('/Save_setting','SettingController@save_setting')  ->name('save.setting');
  Route::post('/search_get_barcode','SettingController@search_get_barcode')  ->name('search.get.barcode');
});
Route::group(['prefix' => 'Customers' , 'namespace' => 'Customers'] ,function()
{
  Route::get('/Customers'       ,'CustomersController@view_customers')->name('view.customers');
  Route::post('/Save_customer'  ,'CustomersController@save_customer')->name('save.customer');
  Route::post('/Update_customer','CustomersController@update_customer')->name('update.customer');
  Route::post('/Active_customer','CustomersController@active_customer')->name('active.customer');
  Route::post('/Search_customer','CustomersController@search_customer')->name('search.customer');
  Route::post('/Delete_customer','CustomersController@delete_customer')->name('delete.customer');

});


