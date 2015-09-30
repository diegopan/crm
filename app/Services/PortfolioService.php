<?php

namespace Crm\Services;


use Carbon\Carbon;
use Crm\Entities\Client;
use Crm\Entities\Member;
use Crm\Entities\Portfolio;
use Crm\Entities\Team;
use Crm\Repositories\PortfolioRepository;
use Crm\Repositories\PortfolioReschedulingRepository;
use Crm\Validators\PortfolioValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class PortfolioService
{

    /**
     * @var PortfolioRepository
     */
    private $repository;


    /**
     * @var PortfolioValidator
     */
    private $validator;
    /**
     * @var ClientService
     */
    private $clientService;
    /**
     * @var TeamService
     */
    private $teamService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var MemberService
     */
    private $memberService;
    /**
     * @var PortfolioReschedulingRepository
     */
    private $reschedulingRepository;


    /**
     * @param PortfolioRepository $repository
     * @param PortfolioValidator $validator
     * @param ClientService $clientService
     * @param TeamService $teamService
     * @param UserService $userService
     * @param MemberService $memberService
     * @param PortfolioReschedulingRepository $reschedulingRepository
     */
    public function __construct(
        PortfolioRepository $repository,
        PortfolioValidator $validator,
        ClientService $clientService,
        TeamService $teamService,
        UserService $userService,
        MemberService $memberService,
        PortfolioReschedulingRepository $reschedulingRepository
    )
    {

        $this->repository = $repository;
        $this->validator = $validator;
        $this->clientService = $clientService;
        $this->teamService = $teamService;
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->reschedulingRepository = $reschedulingRepository;
    }



    public function all(){
        return response()->json([$this->repository->with(['team','client','member'])->all()]);
    }


    public function listAll($member_id)
    {
        try {

            if (Member::findOrFail($member_id)) {

                return response()->json([Portfolio::with('client')->where('member_id', '=', $member_id)->get()]);

            }


        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => true, "debug" => $e->getMessage(), "message" => "Member not found"], 412);
        }
    }


    /**
     * @param $member_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll($member_id)
    {
        try {
            if (Member::findOrFail($member_id)) {

                $weekDay = Carbon::now('America/Sao_Paulo')->dayOfWeek;

                if($weekDay == 1){
                    $weekDay = 'seg';
                }

                if($weekDay == 2){
                    $weekDay = 'ter';
                }

                if($weekDay == 3){
                    $weekDay = 'qua';
                }

                if($weekDay == 4){
                    $weekDay = 'qui';
                }

                if($weekDay == 5){
                    $weekDay = 'sex';
                }

                $today = Carbon::now('America/Sao_Paulo')->toDateString();


                /** @var Object $queryExcpt
                 *  Objeto contendo todos os reagendamentos realidados no dia corrente.
                 *  O objeto é transformado em um array logo em seguida.
                 */
                $queryExcpt = DB::table('portfolio_reschedulings')
                    ->where('portfolio_reschedulings.created_at', '>=', $today)
                    ->select('portfolio_reschedulings.portfolio_id')
                    ->get();


                $queryFinalized = DB::table('portfolio_attendances')
                    ->where('portfolio_attendances.created_at', '>=', $today)
                    ->select('portfolio_attendances.portfolio_id')
                    ->get();

                $except = [];$finalized = [];

                foreach ($queryExcpt as $ob) {
                    $except[] = $ob->portfolio_id;
                }

                foreach ($queryFinalized as $ob) {
                    $finalized[] = $ob->portfolio_id;
                }


                /*
                 * Select que busca todos os clientes da carteira, que possuem configuração de atendimento com horário
                 * marcado para o dia corrente.
                 * Esta select exclui os clientes que possuem reagendamento e também os clientes com atendimento finalizado do dia corrente.
                 */
                $query1 = DB::table('portfolios')
                    ->join('clients', 'portfolios.client_id', '=', 'clients.id')
                    ->join('portfolio_configs', 'portfolios.id', '=', 'portfolio_configs.portfolio_id')
                    ->leftJoin('sales', 'portfolios.client_id', '=', 'sales.client_id')
                    ->where('portfolios.member_id', '=', $member_id)
                    ->whereNotNull("portfolio_configs.$weekDay")
                    ->whereNotIn('portfolios.id', $except)
                    ->whereNotIn('portfolios.id', $finalized)
                    ->select('portfolios.id as portfolio_id', 'portfolios.client_id as client_id', 'portfolios.team_id as team_id', 'portfolios.responsible as contato', 'portfolios.phone as fone', 'portfolios.email as email',
                        'clients.cnpj as cnpj', 'clients.cod as cod_cli', 'clients.razao as razao', 'clients.uf as uf', "portfolio_configs.$weekDay as horario");


                /*
                 * Select que busca todos os clientes de uma carteira que possuem reagendamento no dia corrente.
                 * Esta select se une à select anterior e em seguida os registros são ordenados por horario.
                 * Esta select exclui todos os clientes com atendimento finalizado do dia corrente.
                 */
                $query2 = DB::table('portfolios')
                    ->join('clients', 'portfolios.client_id', '=', 'clients.id')
                    ->join('portfolio_reschedulings', 'portfolios.id', '=', 'portfolio_reschedulings.portfolio_id')
                    ->leftJoin('sales', 'portfolios.client_id', '=', 'sales.client_id')
                    ->where('portfolios.member_id', '=', $member_id)
                    ->where('portfolio_reschedulings.created_at', '>=', $today)
                    ->whereNotNull('portfolio_reschedulings.newtime')
                    ->whereNotIn('portfolios.id', $finalized)
                    ->select('portfolios.id as portfolio_id', 'portfolios.client_id as client_id', 'portfolios.team_id as team_id', 'portfolios.responsible as contato', 'portfolios.phone as fone', 'portfolios.email as email',
                        'clients.cnpj as cnpj', 'clients.cod as cod_cli', 'clients.razao as razao', 'clients.uf as uf', "portfolio_reschedulings.newtime as horario")
                    ->union($query1)
                    ->groupBy("sales.client_id")
                    ->orderBy('horario', 'ASC')
                    ->get();

                /*
                 * Ajusta as informações de telefone e horarios.
                 */
                foreach ($query2 as $k) {
                    $k->fone = json_decode($k->fone);
                    $k->horario = date('H:i', strtotime($k->horario));
                }


                // dd($query2);exit;


                return response()->json([
                    $query2
                ]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => true, "debug" => $e->getMessage(), "message" => "Member not found"], 412);
        }

    }


    /**
     * @param $team_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllByTeam($team_id)
    {
        return response()->json($this->repository->findWhere(["team_id" => $team_id]));
    }


    public function getAllByClient($client_id)
    {
        return response()->json($this->repository->findWhere(["client_id" => $client_id]));
    }


    public function show($id)
    {
        try {
            $portfolio = Portfolio::with(['client', 'config', 'member', 'team'])->findOrFail($id);
            //dd($portfolio);exit;
            if ($portfolio->phone != null && $portfolio->phone != '') {
                $portfolio->phone = json_decode($portfolio->phone);
            }

            if ($portfolio->email != null && $portfolio->email != '') {
                $portfolio->email = json_decode($portfolio->email);
            }


            if ($portfolio->config != null && $portfolio->config != '') {
                $portfolio->config = $portfolio->config->toArray();
            }

            return response()->json($portfolio);
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


        $toSave = [];

        try {

            $toSave['client_id'] = $data['client_id'];
            $toSave['team_id'] = $data['team_id'];
            $toSave['member_id'] = $data['member_id'];




            /*
             * Validation && Save
             */
            try {

                $this->validator->with($toSave)->passesOrFail(ValidatorInterface::RULE_CREATE);
                return response()->json($this->repository->create($toSave));

            } catch (ValidatorException $e) {

                return response()->json([
                    "error" => true,
                    "message" => $e->getMessageBag()
                ], 412);
            }


        } catch (ModelNotFoundException $e) {

            return response()->json(["error" => true, "message" => $e->getMessage()], 412);
        }

    }


    public function storeMany(array $data)
    {

        $toSave = [];
        $ln = [];
        $lineError = [];
        $preError = [];

        foreach ($data as $k => $row) {


            if ($this->memberService->countByParam(['sap' => $row['sap']]) == 0) {
                $lineError[$k]['sap'] = 'Operador invalido';
            }


            if ($this->teamService->countByParam(['slug' => $row['equipe']]) == 0) {
                $lineError[$k]['team'] = 'Equipe invalida';
            }


            if ($this->clientService->countByParam(['cnpj' => $row['cnpj']]) == 0) {
                $lineError[$k]['cnpj'] = 'Cliente invalido';
            }

            if (isset($lineError[$k]) && count($lineError[$k]) > 0) {

                $lineError[$k]['row'] = $row;
                array_push($preError, $lineError[$k]);
            }
        }

        /*
         * Se os dados usuario ou equipe forem invalidos, retorna um erro informando.
         */
        if (count($preError) > 0) {

            return response()->json(['error' => true, 'pre' => $preError], 412);
        }


        foreach ($data as $y => $row) {
            // dd($row);exit;

            $member = $this->memberService->findByParam(['sap' => $row['sap']]);
            $team = $this->teamService->findByParam(['slug' => $row['equipe']]);
            $client = $this->clientService->findByParam(['cnpj' => $row['cnpj']]);


            $ln[$y] = [
                'client_id' => $client[0]['id'],
                'team_id' => $team[0]['id'],
                'member_id' => $member[0]['id'],
                'responsible' => $row['contato'],
                'phone' => $row['fone'],
                'email' => $row['email'],
                'created_at' => Carbon::now('America/Sao_Paulo'),
                'updated_at' => Carbon::now('America/Sao_Paulo'),
            ];


            if ($this->validator->with($ln[$y])->passes(ValidatorInterface::RULE_CREATE)) {
                array_push($toSave, $ln[$y]);
            } else {

                $lineError[$y]['val'] = $this->validator->errorsBag()->getMessageBag();
            }


            if (isset($lineError[$y]) && count($lineError[$y]) > 0) {

                $lineError[$y]['row'] = $row;

                array_push($preError, $lineError[$y]);
            }

        }

        if (count($preError) > 0) {

            return response()->json(['error' => true, 'val' => $preError], 412);

        }


        try {

            return response()->json(['success' => Member::insert($toSave), 'count' => count($toSave)]);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
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

            if (Portfolio::findOrFail($id)) {


                if (isset($data['phone']) && $data['phone'] !== '' && $data['phone'] !== null) {
                    $data['phone'] = json_encode(explode(',', $data['phone']));
                }
                if (isset($data['email']) && $data['email'] !== '' && $data['email'] !== null) {
                    $data['email'] = json_encode(explode(',', $data['email']));
                }


                // dd($data);exit;

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
            if (Portfolio::findOrFail($id)) {
                return response()->json(['success' => $this->repository->delete($id)]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
    }


    public function getConfigColumns()
    {
        return Schema::getColumnListing('portfolio_configs');
    }


    public function reschedule(array $data, $id)
    {
        try {
            if (Portfolio::findOrFail($id)) {

                $query = DB::table('portfolio_reschedulings')->where('portfolio_id', '=', $data['portfolio_id'])->where('created_at', '>=', date('Y-m-d'))->count();
                if ($query > 0) {
                    $obj = $query = DB::table('portfolio_reschedulings')
                        ->where('portfolio_id', '=', $data['portfolio_id'])
                        ->where('created_at', '>=', date('Y-m-d'))
                        ->orderBy('portfolio_reschedulings.created_at', 'DESC')
                        ->limit('1,1')
                        ->get();

                    return response()->json(['success' => $this->reschedulingRepository->update($data, $obj[0]->id)]);
                }

                return response()->json(['success' => $this->reschedulingRepository->create($data)]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ], 404);
        }
    }


}