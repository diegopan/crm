<?php

namespace Crm\Services;


use Carbon\Carbon;
use Crm\Entities\Member;
use Crm\Repositories\MemberRepository;
use Crm\Validators\MemberValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\CountValidator\Exception;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class MemberService
{
    /**
     * @var MemberRepository
     */
    private $repository;
    /**
     * @var MemberValidator
     */
    private $validator;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var TeamService
     */
    private $teamService;


    /**
     * @param MemberRepository $repository
     * @param MemberValidator $validator
     * @param \Crm\Services\UserService $userService
     * @param TeamService $teamService
     */
    public function __construct(MemberRepository $repository, MemberValidator $validator, UserService $userService, TeamService $teamService)
    {

        $this->repository = $repository;
        $this->validator = $validator;
        $this->userService = $userService;
        $this->teamService = $teamService;
    }


    /**
     * @return mixed
     */
    public function getAll()
    {
        return response()->json($this->repository->with(['team', 'user', 'portfolios'])->all());
    }


    public function show($id)
    {
        try {
            return response()->json($this->repository->with(['team', 'user', 'portfolios'])->find($id));
        } catch (ModelNotFoundException $e) {
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
     * @param array $data
     * @param $id
     * @return array
     */
    public function update(array $data, $id)
    {
        try {

            if (Member::findOrFail($id)) {

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


    public function delete($id)
    {
        try {
            if (Member::findOrFail($id)) {
                return response()->json(['success' => $this->repository->delete($id)]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
    }


    /**
     * Create new Members
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMany(array $data)
    {




        $toSave = [];
        $ln = [];
        $lineError =[];
        $preError = [];

        foreach ($data as $k => $row) {



            if( $this->userService->countByParam(['username' => $row['username']]) == 0   ) {
                $lineError[$k]['user'] = 'Username invalido';
            }


            if( $this->teamService->countByParam(['slug' => $row['equipe']]) == 0) {
                $lineError[$k]['team'] = 'Equipe invalida';
            }

            if(isset($lineError[$k]) && count($lineError[$k]) > 0){

               $lineError[$k]['row'] = $row;

                array_push($preError, $lineError[$k]);
            }
        }

        /*
         * Se os dados usuario ou equipe forem invalidos, retorna um erro informando.
*/
        if(count($preError) > 0){

           return response()->json(['error' => true, 'pre' => $preError],412);

        }


        foreach ($data as $y => $row){
           // dd($row);exit;

            $user = $this->userService->findByParam(['username' => $row['username']]);
            $team = $this->teamService->findByParam(['slug' => $row['equipe']]);



            $ln[$y] = [
                'user_id' => $user[0]['id'],
                'team_id' => $team[0]['id'],
                'sap' => $row['sap'],
                'created_at' => Carbon::now('America/Sao_Paulo'),
                'updated_at' => Carbon::now('America/Sao_Paulo'),
            ];


            if($this->validator->with($ln[$y])->passes(ValidatorInterface::RULE_CREATE)) {
                array_push($toSave, $ln[$y]);
            }else{

                $lineError[$y]['val'] = $this->validator->errorsBag()->getMessageBag();
            }



            if(isset($lineError[$y]) && count($lineError[$y]) > 0){

                $lineError[$y]['row'] = $row;

                array_push($preError, $lineError[$y]);
            }

        }

        if(count($preError) > 0){

            return response()->json(['error' => true, 'val' => $preError],412);

        }


        try{

            return response()->json(['success' => Member::insert($toSave), 'count' => count($toSave)]);
        }catch (Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
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