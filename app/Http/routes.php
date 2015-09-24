<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('crm');
});


Route::get('/agenda', function () {
    return view('agenda/home');
});


Route::post('oauth/access_token', function () {
    return Response::json(Authorizer::issueAccessToken());
});


Route::group(['middleware' => 'oauth'], function () {

    /*
     * User  Routes
     */
     Route::get('user/authenticated', ['uses' => 'UserController@authenticated']);
    Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);


    /*
     * User Group Routes
     */
    Route::resource('group', 'UserGroupController', ['except' => ['create', 'edit']]);


    /*
     * Team Routes
     */
    Route::resource('team', 'TeamController', ['except' => ['create', 'edit']]);
    Route::group(['prefix' => 'team'], function () {
        Route::get('{teamId}/member', ['uses' => 'MemberController@index']);
        Route::get('{teamId}/member/{memberId}', ['uses' => 'MemberController@show']);

    });


    /*
     * Member Routes
     */
    Route::resource('member', 'MemberController', ['except' => ['create', 'edit']]);
    Route::post('member/storemany', ['uses' => 'MemberController@storeMany']);



    /*
    *   Client Routes
    */
    Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);


    Route::group(['prefix' => 'client/addmany'], function () {
        Route::post('', ['uses' => 'ClientController@storeMany']);
    });


    /*
     * Portfolio Routes
     */
    Route::resource('portfolio', 'PortfolioController', ['except' => ['index', 'create', 'edit']]);
    Route::group(['prefix' => 'portfolio'], function () {

        Route::get('member/{member_id}/list', ['uses' => 'PortfolioController@listAll']);
        Route::get('member/{member_id}', ['uses' => 'PortfolioController@indexByMember']);
        Route::get('team/{team_id}', ['uses' => 'PortfolioController@indexByTeam']);
        Route::get('client/{client_id}', ['uses' => 'PortfolioController@indexByClient']);
        Route::get('{portfolio_id}/config', ['uses' => 'PortfolioConfigController@index']);
        Route::post('{portfolio_id}/reschedule', ['uses' => 'PortfolioController@reschedule']);
        Route::post('storemany', ['uses' => 'PortfolioController@storeMany']);
    });



    Route::resource('portfolioconfig', 'PortfolioConfigController', ['except' => ['index', 'create', 'edit']]);



    /*
     * Sale Routes
     */
    Route::resource('sale', 'SaleController', ['except' => ['index','create', 'edit']]);
    Route::group(['prefix' => 'sale'], function () {

        Route::get('client/{cliId}/member/{memberId}/tags','SaleController@getTags');
        Route::get('member/{memberId}/client/{cliId}/history','SaleController@getHistory');
        Route::get('client/{cliId}/member/{memberId}','SaleController@getByCli');
    });


    Route::group(['prefix' => 'status'], function(){
        Route::get('member/{memberId}/daily','StatusController@getDailyStatusByMember');
        Route::get('member/{memberId}/monthly','StatusController@getMonthlyStatusByMember');
    });


    Route::group(['prefix' => 'cip'], function(){
        Route::get('cnpj/{cnpj}/tri','CipController@getTrimestralCnpj');
        Route::get('carteira/{memberId}/tri','CipController@getTrimestralCarteira');
    });

});













