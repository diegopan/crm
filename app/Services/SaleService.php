<?php


namespace Crm\Services;


use Carbon\Carbon;
use Crm\Entities\Member;
use Crm\Entities\Sale;
use Crm\Repositories\SaleRepository;
use Crm\Validators\SaleValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class SaleService
{

    /**
     * @var SaleValidator
     */
    private $validator;
    /**
     * @var SaleRepository
     */
    private $repository;

    /**
     * @param SaleRepository $repository
     * @param SaleValidator $validator
     */
    public function __construct(SaleRepository $repository, SaleValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }




    public function getHistoryByClient( $memberId, $cliId = null)
    {

        try{

            $sales = Sale::with('client')
                ->where('member_id', $memberId)
                ->where('client_id', $cliId)
                ->orderBy('sales.created_at','desc')
                ->get();

            foreach($sales as $ob){
                $ob->tags = explode(',',json_decode($ob->tags));
            }

            foreach($sales as $ob){
                $ob->data = $ob->created_at->format('d/m/Y H:i');
            }

            return response()->json([
                "success" => $sales
            ]);

        }catch (ModelNotFoundException $e){

            return response()->json(['error' => true, 'message' => $e->getMessage()], 412);
        }
    }



    public function getByClient( $cliId, $memberId)
    {

        try{

            $sales = Sale::where('created_at', '>=', date('Y-m-d'))
                ->where('client_id', $cliId)
                ->where('member_id', $memberId)
                ->get();

            foreach($sales as $ob){
                $ob->tags = explode(',',json_decode($ob->tags));
            }

            return response()->json([
                "success" => $sales
            ]);

        }catch (ModelNotFoundException $e){

            return response()->json(['error' => true, 'message' => $e->getMessage()], 412);
        }
    }




    public function getLastTags($cliId, $memberId){
        $date = Carbon::now('America/Sao_Paulo')->toDateTimeString();
        try{

            $query = DB::table('sales')
                ->where('client_id', '=', $cliId)
                ->where('member_id', '=', $memberId)
                ->where('created_at', '<=', $date)
                ->where('deleted_at', '=', null)
                ->whereNotNull('tags')
                ->select('sales.tags')
                ->orderBy('created_at', 'DESC')
                ->limit('1,1')
                ->get();

            $tag = '';
            foreach($query as $obj){
                $tag .= ','.json_decode($obj->tags);
            }

            $tags = explode(',',$tag);
            $response = [];

            foreach($tags as $k => $tg){
                if(!$tg == ""){
                    $response[] = $tg;
                }
            }

            return response()->json(['success' => $response]);

        }catch (ModelNotFoundException $e){
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 412);
        }
    }



    public function store(array $data)
    {

        if(isset($data['value'])){
            $data['value'] = str_replace(',','.',$data['value']);
        }

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(array $data, $id)
    {
        try {

            if(isset($data['tags'])){
                $data['tags'] = json_encode($data['tags']);
            }

            if (Sale::findOrFail($id)) {

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
        try{
            if( Sale::findOrFail($id) ) {
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