<?php

namespace Crm\Services;


use Carbon\Carbon;
use Crm\Entities\Client;
use Crm\Entities\User;
use Crm\Repositories\ClientRepository;
use Crm\Validators\AuthorizationGroupValidator;
use Crm\Validators\ClientValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Mockery\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
    /**
     * @var ClientRepository
     */
    private $repository;
    /**
     * @var ClientValidator
     */
    private $validator;
    /**
     * @var AuthorizationGroupValidator
     */
    private $groupValidator;

    /**
     * @param ClientRepository $repository
     * @param ClientValidator $validator
     * @param AuthorizationGroupValidator $groupValidator
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator, AuthorizationGroupValidator $groupValidator)
    {

        $this->repository = $repository;
        $this->validator = $validator;
        $this->groupValidator = $groupValidator;
    }


    /**
     * List all Clients
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        /*
        if ($this->groupValidator->isAdmin()) {

            return response()->json($this->repository->all());
        }
        */
        return response()->json($this->repository->all());
        /* return response()->json([
             "error" => true,
             "message" => "access forbidden"
         ], 401); */
    }


    /**
     * Get one Client by id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        if ($this->groupValidator->isAdmin()) {

            try {
                return response()->json(Client::findOrFail($id));
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    "error" => true,
                    "message" => $e->getMessage()
                ], 404);
            }

        }

        return response()->json([
            "error" => true,
            "message" => "access forbidden"
        ], 401);


    }


    /**
     * Create one new Client
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $data)
    {


            try {

                $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
                return response()->json($this->repository->create($data));

            } catch (ValidatorException $e) {

                return response()->json([
                    "error" => true,
                    "message" => $e->getMessageBag()
                ], 412);
            }

    }


    /**
     * Create new Clients
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMany(array $data)
    {



            foreach ($data as $key => $o) {

                $o['created_at'] =  Carbon::now('America/Sao_Paulo')->toDateTimeString();
                $o['updated_at'] =  Carbon::now('America/Sao_Paulo')->toDateTimeString();
                $o['deleted_at'] =  null;

                $data[$key] = $o;
            }





                DB::beginTransaction();
                try{

                    Client::insert($data);
                    DB::commit();
                    return response()->json(["success" => true]);

                }catch (Exception $e){
                    DB::rollBack();
                    return response()->json(["error" => true, "message" => "falha ao inserir no banco"], 412);
                }



    }


    /**
     * Update one Client Registry
     *
     * @param array $data
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(array $data, $id)
    {

        if ($this->groupValidator->isAdmin()) {

            try {

                if (Client::findOrFail($id)) {

                    try {
                        $this->validator->with($data)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                        return response()->json($this->repository->update($data, $id));

                    } catch (ValidatorException $e) {

                        return response()->json([
                            "error" => true,
                            "message" => $e->getMessageBag()
                        ], 412);
                    }

                }

            } catch (ModelNotFoundException $e) {

                return response()->json([
                    "error" => true,
                    "message" => $e->getMessage()
                ], 404);
            }
        }

        return response()->json([
            "error" => true,
            "message" => "access forbidden"
        ], 401);

    }


    /**
     * Delete one Client
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {

        if ($this->groupValidator->isAdmin()) {

            try {
                if (Client::findOrFail($id)) {
                    return response()->json(['success' => $this->repository->delete($id)]);
                }
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    "error" => true,
                    "message" => $e->getMessage()
                ], 404);
            }
        }

        return response()->json([
            "error" => true,
            "message" => "access forbidden"
        ], 401);


    }



    public function findByParam( array $param ){
        try{
            return $this->repository->findWhere($param);

        }catch (ModelNotFoundException $e){
            return $e->getMessage();
        }
    }


    public function countByParam( array $param ){
        try{
            return $this->repository->findWhere($param)->count();

        }catch (ModelNotFoundException $e){
            return $e->getMessage();
        }
    }


}