<?php

namespace Crm\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CipService
{

    private $weekDay;

    private $today;

    private $db;


    public function __construct()
    {
        $this->db = DB::connection('cip_mysql');
        $this->weekDay = Carbon::now('America/Sao_Paulo')->dayOfWeek;
        $this->today = Carbon::now('America/Sao_Paulo')->toDateString();

    }


    public function getTrimestralCnpj($cnpj)
    {


        $query = $this->db->table('vendas')
            ->where('vendas.cnpj_cli', '=', $cnpj)
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '<=', DB::raw("EXTRACT(year_month FROM now())"))
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '>=', DB::raw("PERIOD_ADD(EXTRACT(year_month FROM now()),-6)"))
            ->select(
                DB::raw('ROUND(SUM(vendas.venda_bruta)/6,2) as venda_bruta'),
                DB::raw('ROUND(SUM(vendas.qtd_pedidos)/6,0) as qtd_pedidos'),
                DB::raw('ROUND( SUM( (vendas.venda_bruta)/6) / SUM( (vendas.qtd_pedidos)/6),2) as ticket_medio'),
                DB::raw('ROUND(SUM(vendas.media_semanal)/6,2) as media_semanal'),
                DB::raw('ROUND(SUM(vendas.lob_televendas)/6,2) as lob_televendas'),
                DB::raw('ROUND(SUM(vendas.lob)/6,2) as lob'),
                DB::raw('ROUND(SUM(vendas.valor_generico)/6,2) as valor_generico'),
                DB::raw('ROUND(SUM(vendas.valor_otc)/6,2) as valor_otc'),
                DB::raw('ROUND(SUM(vendas.valor_hb)/6,2) as valor_hb'),
                DB::raw('ROUND(SUM(vendas.valor_outros)/6,2) as valor_outros'),
                DB::raw('ROUND(SUM(vendas.valor_opl)/6,2) as valor_opl'),
                DB::raw('ROUND(SUM(vendas.valor_nao_opl)/6,2) as valor_nao_opl'),
                DB::raw('ROUND(SUM(vendas.valor_televendas)/6,2) as valor_televendas'),
                DB::raw('ROUND(SUM(vendas.valor_telemarketing)/6,2) as valor_telemarketing'),
                DB::raw('ROUND(SUM(vendas.valor_panconnect)/6,2) as valor_panconnect')
            )
            ->get();
        $result = '';
        foreach($query as $k => $row){




            $row->qtd_pedidos = number_format($row->qtd_pedidos,2,',','.');
            $row->ticket_medio = number_format($row->ticket_medio,2,',','.');
            $row->media_semanal = number_format($row->media_semanal,2,',','.');
            $row->valor_generico = number_format($row->valor_generico,2,',','.');
            $row->valor_otc = number_format($row->valor_otc,2,',','.');
            $row->valor_hb = number_format($row->valor_hb,2,',','.');
            $row->valor_outros = number_format($row->valor_outros,2,',','.');
            $row->valor_opl = number_format($row->valor_opl,2,',','.');
            $row->valor_nao_opl = number_format($row->valor_nao_opl,2,',','.');
            $row->valor_eletronico = number_format( $row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing) ,2,',','.');
            $row->valor_televendas = number_format($row->valor_televendas,2,',','.');
            $row->valor_telemarketing = number_format($row->valor_telemarketing,2,',','.');
            $row->valor_panconnect = number_format($row->valor_panconnect,2,',','.');
            $row->lob = number_format($row->lob,2,',','.');
            $row->lob_televendas = number_format($row->lob_televendas,2,',','.');
            $row->venda_bruta = number_format($row->venda_bruta,2,',','.');

            $result = $row;

        }


        return response()->json(['success' => $result]);

    }




    public function getTrimestralCarteira($carteira)
    {
        $clients = DB::connection('mysql')
            ->table('portfolios')
            ->join('clients', 'portfolios.client_id', '=', 'clients.id')
            ->where('portfolios.member_id', '=', $carteira)
            ->select('clients.cnpj')
            ->get();

        $carteira = [];

        foreach($clients as $k => $ob){
            $carteira[] = $ob->cnpj;
        }



        $query = $this->db->table('vendas')
            ->whereIn('vendas.cnpj_cli', $carteira)
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '<=', DB::raw("EXTRACT(year_month FROM now())"))
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '>=', DB::raw("PERIOD_ADD(EXTRACT(year_month FROM now()),-6)"))
            ->select(
                DB::raw('ROUND(SUM(vendas.venda_bruta)/6,2) as venda_bruta'),
                DB::raw('ROUND(SUM(vendas.qtd_pedidos)/6,0) as qtd_pedidos'),
                DB::raw('ROUND( SUM( (vendas.venda_bruta)/6) / SUM( (vendas.qtd_pedidos)/6),2) as ticket_medio'),
                DB::raw('ROUND(SUM(vendas.media_semanal)/6,2) as media_semanal'),
                DB::raw('ROUND(SUM(vendas.valor_generico)/6,2) as valor_generico'),
                DB::raw('ROUND(SUM(vendas.valor_otc)/6,2) as valor_otc'),
                DB::raw('ROUND(SUM(vendas.valor_hb)/6,2) as valor_hb'),
                DB::raw('ROUND(SUM(vendas.valor_outros)/6,2) as valor_outros'),
                DB::raw('ROUND(SUM(vendas.valor_televendas)/6,2) as valor_televendas'),
                DB::raw('ROUND(SUM(vendas.valor_telemarketing)/6,2) as valor_telemarketing'),
                DB::raw('ROUND(SUM(vendas.valor_panconnect)/6,2) as valor_panconnect')
            )
            ->get();


        $result = [];
        foreach($query as $k => $row){


            $row->qtd_pedidos = number_format($row->qtd_pedidos,0,',','.');
            $row->ticket_medio = number_format($row->ticket_medio,2,',','.');
            $row->media_semanal = number_format($row->media_semanal,2,',','.');
            $row->valor_generico = number_format($row->valor_generico,2,',','.');
            $row->valor_otc = number_format($row->valor_otc,2,',','.');
            $row->valor_hb = number_format($row->valor_hb,2,',','.');
            $row->valor_outros = number_format($row->valor_outros,2,',','.');
            $row->valor_eletronico = number_format( $row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing) ,2,',','.');
            $row->valor_televendas = number_format($row->valor_televendas,2,',','.');
            $row->valor_telemarketing = number_format($row->valor_telemarketing,2,',','.');
            $row->valor_panconnect = number_format($row->valor_panconnect,2,',','.');
            $row->venda_bruta = number_format($row->venda_bruta,2,',','.');

            $result = $row;

        }

        return response()->json(['success' => $result]);

    }


}