<?php

namespace Crm\Services;


use Crm\Entities\PortfolioConfig;
use Crm\Repositories\PortfolioConfigRepository;
use Crm\Validators\PortfolioConfigValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class PortfolioConfigService
{

    /**
     * @var PortfolioConfigRepository
     */
    private $repository;



    /**
     * @var PortfolioConfigValidator
     */
    private $validator;


    /**
     * @param PortfolioConfigRepository $repository
     * @param PortfolioConfigValidator $validator
     */
    public function __construct( PortfolioConfigRepository $repository, PortfolioConfigValidator $validator)
    {

        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * @param portfolio_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll($portfolio_id)
    {
        return response()->json($this->repository->findWhere(["portfolio_id" => $portfolio_id]));
    }






    public function show($id)
    {
        try{
            return response()->json(PortfolioConfig::findOrFail($id));
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

            //dd($data);exit;
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

            if( PortfolioConfig::findOrFail($id) ) {

               try{
                   $this->validator->with($data)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                   return response()->json( ["success" => PortfolioConfig::where('id', $id)->where('portfolio_id', $data['portfolio_id'])->update($data)]);

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
            ], 412);
        }
    }






    public function delete($id)
    {
        try{
            if( PortfolioConfig::findOrFail($id) ) {
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