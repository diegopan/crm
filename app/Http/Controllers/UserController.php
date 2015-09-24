<?php

namespace Crm\Http\Controllers;

use Crm\Repositories\UserRepository;
use Crm\Services\UserService;
use Illuminate\Http\Request;

use Crm\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{


    /**
     * @var UserService
     */
    private $service;
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @param UserService $service
     * @param UserRepository $repository
     */
    public function __construct(UserService $service, UserRepository $repository){

        $this->service = $service;
        $this->repository = $repository;
    }



    public function authenticated()
    {
        $userId = Authorizer::getResourceOwnerId();
        return response()->json($this->repository->with(['group','member'])->find($userId));
    }



    public function search()
    {
        return $this->service->search();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->service->getAll();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->save($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
