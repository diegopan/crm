<?php

namespace Crm\Services;


use Crm\Entities\User;
use Crm\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService
{


    /**
     * @var User
     */
    private $model;
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(User $model, UserRepository $repository)
    {

        $this->model = $model;
        $this->repository = $repository;
    }


    public function search()
    {
        try {

            $members = DB::table('members')->distinct()->select('user_id')->get();
            $memberIds = [];
            foreach ($members as $k) {
                $memberIds[] = $k->user_id;
            }


            $response = DB::table('users')
                ->join('members', 'users.id', '=', 'members.user_id')
                ->select('users.id', 'users.name', 'users.username', 'members.id as member_id')
                ->whereNotIn('id', $memberIds)
                ->get();

            return response()->json($response);

        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => true, "message" => $e->getMessage()], 412);
        }

    }


    /**
     * @return mixed
     */
    public function getAll()
    {
        return response()->json($this->repository->with('group')->all());
    }


    /**
     * @return mixed
     */
    public function show($id)
    {
        try {
            return response()->json($this->model->findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => true, "message" => $e->getMessage()], 412);
        }
    }


    public function findByParam(array $param)
    {
        try {
            return $this->repository->findWhere($param);

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }


    public function countByParam(array $param)
    {
        try {
            return $this->repository->findWhere($param)->count();

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }


    public function save(array $data)
    {
        try {
            return response()->json(['success' => $this->repository->create($data)]);
        } catch (ValidatorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessageBag()], 412);
        }
    }


}