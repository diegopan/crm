<?php

namespace Crm\Http\Controllers;


use Crm\Services\MemberService;
use Illuminate\Http\Request;
use Crm\Http\Requests;

class MemberController extends Controller
{

    /**
     * @var MemberService
     */
    private $service;

    /**
     * @param MemberService $service
     */
    public function __construct(MemberService $service){
        $this->service = $service;
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
        return $this->service->store($request->all());
    }



    public function storeMany(Request $request)
    {
        return $this->service->storeMany($request->all());
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
