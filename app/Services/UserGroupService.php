<?php

namespace Crm\Services;


use Crm\Entities\UserGroup;
use Crm\Repositories\UserGroupRepository;
use Crm\Validators\UserGroupValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class UserGroupService
{
    /**
     * @var UserGroupRepository
     */
    private $repository;
    /**
     * @var UserGroupValidator
     */
    private $validator;


    /**
     * @param UserGroupRepository $repository
     * @param UserGroupValidator $validator
     */
    public function __construct( UserGroupRepository $repository, UserGroupValidator $validator)
    {

        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * @return mixed
     */
    public function getAll()
    {
        return response()->json($this->repository->all());
    }



    public function show($id)
    {
        try{
            return response()->json(UserGroup::findOrFail($id));
        }catch (ModelNotFoundException $e){
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
    }



    /**
     * @param array $data
     * @return array
     */
    public function store(array $data)
    {
        try{

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            return response()->json( $this->repository->create($data));

        }catch (ValidatorException $e) {

            return response()->json([
                "error" => true,
                "message" => $e->getMessageBag()
            ], 412);
        }
    }


    /**
     * @param array $data
     * @param $id
     * @return array
     */
    public function update(array $data, $id)
    {
        try{

            if( UserGroup::findOrFail($id) ) {

               try{
                   $this->validator->with($data)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                   return response()->json( $this->repository->update($data, $id));

               }catch (ValidatorException $e){
                   
                   return response()->json([
                       "error" => true,
                       "message" => $e->getMessageBag()
                   ], 412);
               }

            }

        }catch (ModelNotFoundException $e){

            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
    }






    public function delete($id)
    {
        try{
            if( UserGroup::findOrFail($id) ) {
                return response()->json(['success' => $this->repository->delete($id)]);
            }
        }catch (ModelNotFoundException $e){
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
    }


}