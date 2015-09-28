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
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '>=', DB::raw("PERIOD_ADD(EXTRACT(year_month FROM now()),-3)"))
            ->select(
                DB::raw('ROUND(SUM(vendas.venda_bruta)/3,0) as venda_bruta'),
                DB::raw('ROUND(SUM(vendas.qtd_pedidos)/3,0) as qtd_pedidos'),
                DB::raw('ROUND( SUM( (vendas.venda_bruta)/3) / SUM( (vendas.qtd_pedidos)/3),2) as ticket_medio'),
                DB::raw('ROUND(SUM(vendas.media_semanal)/3,0) as media_semanal'),
                DB::raw('ROUND(SUM(vendas.lob_televendas)/3,0) as lob_televendas'),
                DB::raw('ROUND(SUM(vendas.lob)/3,0) as lob'),
                DB::raw('ROUND(SUM(vendas.valor_generico)/3,0) as valor_generico'),
                DB::raw('ROUND(SUM(vendas.valor_otc)/3,0) as valor_otc'),
                DB::raw('ROUND(SUM(vendas.valor_hb)/3,0) as valor_hb'),
                DB::raw('ROUND(SUM(vendas.valor_outros)/3,0) as valor_outros'),
                DB::raw('ROUND(SUM(vendas.valor_opl)/3,0) as valor_opl'),
                DB::raw('ROUND(SUM(vendas.valor_nao_opl)/3,0) as valor_nao_opl'),
                DB::raw('ROUND(SUM(vendas.valor_televendas)/3,0) as valor_televendas'),
                DB::raw('ROUND(SUM(vendas.valor_telemarketing)/3,0) as valor_telemarketing'),
                DB::raw('ROUND(SUM(vendas.valor_panconnect)/3,0) as valor_panconnect')
            )
            ->get();
        $result = '';
        foreach ($query as $k => $row) {

            /*
             * ---------------------------Valores percentuais-----------------------------------------------------
             */


            /*
             * Percentual de genericos
             */
            if ($row->valor_generico > 0 && $row->venda_bruta > 0) {
                $row->perc_generico = number_format(($row->valor_generico / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_genericos = 0;
            }

            /*
             * Percentual de otc
             */
            if ($row->valor_otc > 0 && $row->venda_bruta > 0) {
                $row->perc_otc = number_format(($row->valor_otc / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_otc = 0;
            }

            /*
             * Percentual de hb
             */
            if ($row->valor_hb > 0 && $row->venda_bruta > 0) {
                $row->perc_hb = number_format(($row->valor_hb / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_hb = 0;
            }

            /*
             * Percentual de etico
             */
            if ($row->valor_outros > 0 && $row->venda_bruta > 0) {
                $row->perc_outros = number_format(($row->valor_outros / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_outros = 0;
            }

            /*
             * Percentual de ativo
             */
            if ($row->valor_televendas > 0 && $row->venda_bruta > 0) {
                $row->perc_televendas = number_format(($row->valor_televendas / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_televendas = 0;
            }


            /*
             * Percentual de receptivo
             */
            if ($row->valor_telemarketing > 0 && $row->venda_bruta > 0) {
                $row->perc_telemarketing = number_format(($row->valor_telemarketing / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_telemarketing = 0;
            }


            /*
             * Percentual de eletronico
             */
            $row->valor_eletronico = $row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing);

            if ($row->valor_eletronico > 0 && $row->venda_bruta > 0) {
                $row->perc_eletronico = number_format(($row->valor_eletronico / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_eletronico = 0;
            }


            $row->qtd_pedidos = number_format($row->qtd_pedidos, 0, ',', '.');
            $row->ticket_medio = number_format($row->ticket_medio, 0, ',', '.');
            $row->media_semanal = number_format($row->media_semanal, 0, ',', '.');
            $row->valor_generico = number_format($row->valor_generico, 0, ',', '.');
            $row->valor_otc = number_format($row->valor_otc, 0, ',', '.');
            $row->valor_hb = number_format($row->valor_hb, 0, ',', '.');
            $row->valor_outros = number_format($row->valor_outros, 0, ',', '.');
            $row->valor_opl = number_format($row->valor_opl, 0, ',', '.');
            $row->valor_nao_opl = number_format($row->valor_nao_opl, 0, ',', '.');
            $row->valor_eletronico = number_format($row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing), 0, ',', '.');
            $row->valor_televendas = number_format($row->valor_televendas, 0, ',', '.');
            $row->valor_telemarketing = number_format($row->valor_telemarketing, 0, ',', '.');
            $row->valor_panconnect = number_format($row->valor_panconnect, 0, ',', '.');
            $row->lob = number_format($row->lob, 0, ',', '.');
            $row->lob_televendas = number_format($row->lob_televendas, 0, ',', '.');
            $row->venda_bruta = number_format($row->venda_bruta, 0, ',', '.');

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

        foreach ($clients as $k => $ob) {
            $carteira[] = $ob->cnpj;
        }


        $query = $this->db->table('vendas')
            ->whereIn('vendas.cnpj_cli', $carteira)
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '<=', DB::raw("EXTRACT(year_month FROM now())"))
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '>=', DB::raw("PERIOD_ADD(EXTRACT(year_month FROM now()),-3)"))
            ->select(
                DB::raw('ROUND(SUM(vendas.venda_bruta)/3,0) as venda_bruta'),
                DB::raw('ROUND(SUM(vendas.qtd_pedidos)/3,0) as qtd_pedidos'),
                DB::raw('ROUND( SUM( (vendas.venda_bruta)/3) / SUM( (vendas.qtd_pedidos)/3),0) as ticket_medio'),
                DB::raw('ROUND(SUM(vendas.media_semanal)/3,0) as media_semanal'),
                DB::raw('ROUND(SUM(vendas.valor_generico)/3,0) as valor_generico'),
                DB::raw('ROUND(SUM(vendas.valor_otc)/3,0) as valor_otc'),
                DB::raw('ROUND(SUM(vendas.valor_hb)/3,0) as valor_hb'),
                DB::raw('ROUND(SUM(vendas.valor_outros)/3,0) as valor_outros'),
                DB::raw('ROUND(SUM(vendas.valor_televendas)/3,0) as valor_televendas'),
                DB::raw('ROUND(SUM(vendas.valor_telemarketing)/3,0) as valor_telemarketing'),
                DB::raw('ROUND(SUM(vendas.valor_panconnect)/3,0) as valor_panconnect')
            )
            ->get();


        $result = [];
        foreach ($query as $k => $row) {

            /*
             * ---------------------------Valores percentuais
             */


            /*
             * Percentual de genericos
             */
            if ($row->valor_generico > 0 && $row->venda_bruta > 0) {
                $row->perc_generico = number_format(($row->valor_generico / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_genericos = 0;
            }

            /*
             * Percentual de otc
             */
            if ($row->valor_otc > 0 && $row->venda_bruta > 0) {
                $row->perc_otc = number_format(($row->valor_otc / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_otc = 0;
            }

            /*
             * Percentual de hb
             */
            if ($row->valor_hb > 0 && $row->venda_bruta > 0) {
                $row->perc_hb = number_format(($row->valor_hb / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_hb = 0;
            }

            /*
             * Percentual de etico
             */
            if ($row->valor_outros > 0 && $row->venda_bruta > 0) {
                $row->perc_outros = number_format(($row->valor_outros / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_outros = 0;
            }

            /*
             * Percentual de ativo
             */
            if ($row->valor_televendas > 0 && $row->venda_bruta > 0) {
                $row->perc_televendas = number_format(($row->valor_televendas / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_televendas = 0;
            }


            /*
             * Percentual de receptivo
             */
            if ($row->valor_telemarketing > 0 && $row->venda_bruta > 0) {
                $row->perc_telemarketing = number_format(($row->valor_telemarketing / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_telemarketing = 0;
            }


            /*
             * Percentual de eletronico
             */
            $row->valor_eletronico = $row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing);

            if ($row->valor_eletronico > 0 && $row->venda_bruta > 0) {
                $row->perc_eletronico = number_format(($row->valor_eletronico / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_eletronico = 0;
            }


            $row->qtd_pedidos = number_format($row->qtd_pedidos, 0, ',', '.');
            $row->ticket_medio = number_format($row->ticket_medio, 0, ',', '.');
            $row->media_semanal = number_format($row->media_semanal, 0, ',', '.');
            $row->valor_generico = number_format($row->valor_generico, 0, ',', '.');
            $row->valor_otc = number_format($row->valor_otc, 0, ',', '.');
            $row->valor_hb = number_format($row->valor_hb, 0, ',', '.');
            $row->valor_outros = number_format($row->valor_outros, 0, ',', '.');
            $row->valor_eletronico = number_format($row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing), 0, ',', '.');
            $row->valor_televendas = number_format($row->valor_televendas, 0, ',', '.');
            $row->valor_telemarketing = number_format($row->valor_telemarketing, 0, ',', '.');
            $row->valor_panconnect = number_format($row->valor_panconnect, 0, ',', '.');
            $row->venda_bruta = number_format($row->venda_bruta, 0, ',', '.');


            $result = $row;

        }

        return response()->json(['success' => $result]);

    }


    public function getMesAnteriorCnpj($cnpj)
    {


        $query = $this->db->table('vendas')
            ->where('vendas.cnpj_cli', '=', $cnpj)
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '<=', DB::raw("EXTRACT(year_month FROM now())"))
            ->where(DB::raw("EXTRACT( year_month FROM vendas.data)"), '>=', DB::raw("PERIOD_ADD(EXTRACT(year_month FROM now()),-1)"))
            ->select(
                DB::raw('ROUND(SUM(vendas.venda_bruta),0) as venda_bruta'),
                DB::raw('ROUND(SUM(vendas.qtd_pedidos),0) as qtd_pedidos'),
                DB::raw('ROUND( SUM(vendas.venda_bruta) / SUM(vendas.qtd_pedidos),2) as ticket_medio'),
                DB::raw('ROUND(SUM(vendas.media_semanal),0) as media_semanal'),
                DB::raw('ROUND(SUM(vendas.lob_televendas),0) as lob_televendas'),
                DB::raw('ROUND(SUM(vendas.lob),0) as lob'),
                DB::raw('ROUND(SUM(vendas.valor_generico),0) as valor_generico'),
                DB::raw('ROUND(SUM(vendas.valor_otc),0) as valor_otc'),
                DB::raw('ROUND(SUM(vendas.valor_hb),0) as valor_hb'),
                DB::raw('ROUND(SUM(vendas.valor_outros),0) as valor_outros'),
                DB::raw('ROUND(SUM(vendas.valor_opl),0) as valor_opl'),
                DB::raw('ROUND(SUM(vendas.valor_nao_opl),0) as valor_nao_opl'),
                DB::raw('ROUND(SUM(vendas.valor_televendas),0) as valor_televendas'),
                DB::raw('ROUND(SUM(vendas.valor_telemarketing),0) as valor_telemarketing'),
                DB::raw('ROUND(SUM(vendas.valor_panconnect),0) as valor_panconnect')
            )
            ->get();
        $result = '';
        foreach ($query as $k => $row) {

            /*
             * ---------------------------Valores percentuais-----------------------------------------------------
             */


            /*
             * Percentual de genericos
             */
            if ($row->valor_generico > 0 && $row->venda_bruta > 0) {
                $row->perc_generico = number_format(($row->valor_generico / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_genericos = 0;
            }

            /*
             * Percentual de otc
             */
            if ($row->valor_otc > 0 && $row->venda_bruta > 0) {
                $row->perc_otc = number_format(($row->valor_otc / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_otc = 0;
            }

            /*
             * Percentual de hb
             */
            if ($row->valor_hb > 0 && $row->venda_bruta > 0) {
                $row->perc_hb = number_format(($row->valor_hb / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_hb = 0;
            }

            /*
             * Percentual de etico
             */
            if ($row->valor_outros > 0 && $row->venda_bruta > 0) {
                $row->perc_outros = number_format(($row->valor_outros / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_outros = 0;
            }

            /*
             * Percentual de ativo
             */
            if ($row->valor_televendas > 0 && $row->venda_bruta > 0) {
                $row->perc_televendas = number_format(($row->valor_televendas / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_televendas = 0;
            }


            /*
             * Percentual de receptivo
             */
            if ($row->valor_telemarketing > 0 && $row->venda_bruta > 0) {
                $row->perc_telemarketing = number_format(($row->valor_telemarketing / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_telemarketing = 0;
            }


            /*
             * Percentual de eletronico
             */
            $row->valor_eletronico = $row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing);

            if ($row->valor_eletronico > 0 && $row->venda_bruta > 0) {
                $row->perc_eletronico = number_format(($row->valor_eletronico / $row->venda_bruta) * 100, 0, ',', '.');
            } else {
                $row->perc_eletronico = 0;
            }


            $row->qtd_pedidos = number_format($row->qtd_pedidos, 0, ',', '.');
            $row->ticket_medio = number_format($row->ticket_medio, 0, ',', '.');
            $row->media_semanal = number_format($row->media_semanal, 0, ',', '.');
            $row->valor_generico = number_format($row->valor_generico, 0, ',', '.');
            $row->valor_otc = number_format($row->valor_otc, 0, ',', '.');
            $row->valor_hb = number_format($row->valor_hb, 0, ',', '.');
            $row->valor_outros = number_format($row->valor_outros, 0, ',', '.');
            $row->valor_opl = number_format($row->valor_opl, 0, ',', '.');
            $row->valor_nao_opl = number_format($row->valor_nao_opl, 0, ',', '.');
            $row->valor_eletronico = number_format($row->venda_bruta - ($row->valor_panconnect + $row->valor_televendas + $row->valor_telemarketing), 0, ',', '.');
            $row->valor_televendas = number_format($row->valor_televendas, 0, ',', '.');
            $row->valor_telemarketing = number_format($row->valor_telemarketing, 0, ',', '.');
            $row->valor_panconnect = number_format($row->valor_panconnect, 0, ',', '.');
            $row->lob = number_format($row->lob, 0, ',', '.');
            $row->lob_televendas = number_format($row->lob_televendas, 0, ',', '.');
            $row->venda_bruta = number_format($row->venda_bruta, 0, ',', '.');

            $result = $row;

        }


        return response()->json(['success' => $result]);

    }


}