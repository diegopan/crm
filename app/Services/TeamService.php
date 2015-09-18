<?php

namespace Crm\Services;


use Crm\Entities\Team;
use Crm\Repositories\TeamRepository;
use Crm\Validators\TeamValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class TeamService
{
    /**
     * @var TeamRepository
     */
    private $repository;
    /**
     * @var TeamValidator
     */
    private $validator;


    /**
     * @param TeamRepository $repository
     * @param TeamValidator $validator
     */
    public function __construct( TeamRepository $repository, TeamValidator $validator)
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
            return response()->json(Team::findOrFail($id));
        }catch (ModelNotFoundException $e){
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
    }



    public function getMembers($id)
    {
        try{

            if( Team::findOrFail($id) ) {

                    return response()->json( $this->repository->with(['members'])->find($id));

            }

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

            if( Team::findOrFail($id) ) {

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
            if( Team::findOrFail($id) ) {
                return response()->json(['success' => $this->repository->delete($id)]);
            }
        }catch (ModelNotFoundException $e){
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
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