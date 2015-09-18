<?php

namespace Crm\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatusService
{

    private $weekDay;

    private $today;



    public function __construct()
    {
        $this->weekDay = Carbon::now('America/Sao_Paulo')->dayOfWeek;
        if($this->weekDay == 1){
            $this->weekDay = 'seg';
        }

        if($this->weekDay == 2){
            $this->weekDay = 'ter';
        }

        if($this->weekDay == 3){
            $this->weekDay = 'qua';
        }

        if($this->weekDay == 4){
            $this->weekDay = 'qui';
        }

        if($this->weekDay == 5){
            $this->weekDay = 'sex';
        }
        $this->today = Carbon::now('America/Sao_Paulo')->toDateString();

    }


    public function getDailyStatusByMember($memberId)
    {


        $daily_total = DB::table('portfolios')
            ->join('portfolio_configs', 'portfolios.id', '=', 'portfolio_configs.portfolio_id')
            ->where('member_id', '=', $memberId)
            ->whereNotNull("portfolio_configs.$this->weekDay")
            ->groupBy('portfolios.client_id')
            ->get();


        $daily_posit = DB::table('sales')
            ->where('sales.member_id', '=', $memberId)
            ->where('sales.created_at', '>=', $this->today)
            ->where('sales.deleted_at', '=', null)
            ->groupBy('sales.client_id')
            ->get();



        $daily_sales = DB::table('sales')
            ->where('sales.member_id', '=', $memberId)
            ->where('sales.created_at', '>=', $this->today)
            ->where('sales.deleted_at', '=', null)
            ->select(DB::raw('round(SUM(sales.value),2) as venda'))
            ->get();


        $avg_tiket = DB::table('sales')
            ->where('sales.member_id', '=', $memberId)
            ->where('sales.created_at', '>=', $this->today)
            ->where('sales.deleted_at', '=', null)
            ->select(DB::raw('round(avg(sales.value),2) as avg_tiket'))
            ->get();


        $daily = [
            'agendamentos' => count($daily_total),
            'posit' => count($daily_posit),
            'venda' => number_format($daily_sales[0]->venda,2,',','.'),
            'tiket' => number_format($avg_tiket[0]->avg_tiket,2,',','.')
        ];


        return response()->json(['success' => $daily]);

    }



    public function getMonthlyStatusByMember($memberId)
    {


        $monthly_total = DB::table('portfolios')
            ->where('member_id', '=', $memberId)
            ->get();


        $monthly_posit = DB::table('sales')
            ->where('sales.member_id', '=', $memberId)
            ->where('sales.deleted_at', '=', null)
            ->where(DB::raw("date_format(sales.created_at, '%m')"), '=', DB::raw("date_format(now(),'%m')"))
            ->groupBy('sales.client_id')
            ->get();





        $monthly_sales = DB::table('sales')
            ->where('sales.member_id', '=', $memberId)
            ->where(DB::raw("date_format(sales.created_at, '%m')"), '=', DB::raw("date_format(now(),'%m')"))
            ->where('sales.deleted_at', '=', null)
            ->select(DB::raw('round(SUM(sales.value),2) as venda'))
            ->get();


        $avg_tiket = DB::table('sales')
            ->where('sales.member_id', '=', $memberId)
            ->where(DB::raw("date_format(sales.created_at, '%m')"), '=', DB::raw("date_format(now(),'%m')"))
            ->where('sales.deleted_at', '=', null)
            ->select(DB::raw('round(avg(sales.value),2) as avg_tiket'))
            ->get();


        $monthly = [
            'agendamentos' => count($monthly_total),
            'posit' => count($monthly_posit),
            'venda' => number_format($monthly_sales[0]->venda,2,',','.'),
            'tiket' => number_format($avg_tiket[0]->avg_tiket,2,',','.')
        ];


        return response()->json(['success' => $monthly]);


    }

}