<?php

namespace Crm\Services;


use Crm\Entities\PortfolioAttendance;
use Crm\Repositories\PortfolioAttendanceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class AttendanceService
{



    /**
     * @var PortfolioAttendanceRepository
     */
    private $repository;

    public function __construct( PortfolioAttendanceRepository $repository)
    {

        $this->repository = $repository;
    }




    /**
     * @return mixed
     */
    public function getAll()
    {
        return response()->json($this->repository->with('portfolio')->all());
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



    public function save(array $data)
    {
        try {
            return response()->json(['success' => $this->repository->create($data)]);
        } catch (ValidatorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessageBag()], 412);
        }
    }




    public function update(array $data, $id)
    {

            try {

                if (PortfolioAttendance::findOrFail($id)) {

                    try {

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
                ], 412);
            }

    }



    public function delete($id)
    {
        try{
            if( PortfolioAttendance::findOrFail($id) ) {
                return response()->json(['success' => $this->repository->delete($id)]);
            }
        }catch (ModelNotFoundException $e){
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 412);
        }
    }


}