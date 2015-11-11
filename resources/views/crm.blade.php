<!DOCTYPE html>


<html lang="en" ng-app="crm">

<head>
    <meta charset="utf-8"/>
    <title>Panpharma | CRM</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">


    @if(Config::get('app.debug'))
        <link href="{{ asset('build/css/vendor/font-awesome.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/simple-line-icons.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/bootstrap.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/select.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/bootstrap-theme.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/uniform.default.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/bootstrap-switch.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/layout.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/login-5.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/components.css') }}" type="text/css" rel="stylesheet"/>
      <link href="{{ asset('build/css/darkblue.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/todo.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/datatables.bootstrap.min.css') }}" type="text/css" rel="stylesheet"/>
    @else
        <link href="{{ elixir('css/all.css') }}" type="text/css" rel="stylesheet"/>
    @endif

</head>
<body ng-class="{'login':!currentUser, 'page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed page-quick-sidebar-over-content page-container-bg-solid page-compact': currentUser}" class="">
<span us-spinner="{radius:30, width:8, length: 16}"></span>
<div ng-show="!currentUser" ng-view></div>
<div class="page-header navbar navbar-fixed-top" ng-show="currentUser">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">

            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">

                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user" >
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <i class="fa fa-user"></i>
					<span class="username username-hide-on-mobile">
                        <span ng-bind="currentUser"></span>
					 </span>

                    </a>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a ng-href="#/logout" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                        <span class="username username-hide-on-mobile">Sair</span>
                    </a>
                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>

<div class="page-container" ng-if="currentUser">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- menu operadores -->
            <ul class="page-sidebar-menu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" ng-if="currentGroup == 'CCMZ_Operador'">
                <li class="start ">
                    <a ng-href="/#/agendamentos">
                        <i class="icon-home"></i>
                        <span class="title">Agenda</span>
                        <span class="arrow "></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-wallet"></i>
                        <span class="title">Carteira de Clientes</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a ng-href="/#/carteira">
                                <i class="icon-users"></i>
                                 Meus Clientes</a>
                        </li>
                    </ul>
                </li>

            </ul>

            <!-- menu admins -->
            <ul class="page-sidebar-menu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" ng-if="currentGroup == 'CCMZ_Admin'">
                <li class="start ">
                    <a ng-href="/#/home">
                        <i class="icon-home"></i>
                        <span class="title">Home</span>
                        <span class="arrow "></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-lock"></i>
                        <span class="title">Usu&aacute;rios</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a ng-href="/#/users">
                                <i class="icon-list"></i>
                                Listar</a>
                        </li>
                        <li>
                            <a ng-href="/#/users/new">
                                <i class="fa fa-plus"></i>
                                Novo</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;">
                        <i class="fa fa-database"></i>
                        <span class="title">Clientes</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a ng-href="/#/clients">
                                <i class="icon-list"></i>
                                Listar</a>
                        </li>
                        <li>
                            <a ng-href="/#/clients/new">
                                <i class="fa fa-plus"></i>
                                Novo</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;">
                        <i class="icon-flag"></i>
                        <span class="title">Equipes</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a ng-href="/#/teams">
                                <i class="icon-list"></i>
                                Listar</a>
                        </li>
                        <li>
                            <a ng-href="/#/teams/new">
                                <i class="fa fa-plus"></i>
                                Nova</a>
                        </li>
                    </ul>
                </li>



                <li>
                    <a href="javascript:;">
                        <i class="fa fa-users"></i>
                        <span class="title">Teleoperadores</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">

                        <li>
                            <a ng-href="/#/members">
                                <i class="icon-list"></i>
                                Listar</a>
                        </li>
                        <li>
                            <a ng-href="/#/members/new">
                                <i class="fa fa-user-plus"></i>
                                Novo</a>
                        </li>
                        <li>
                            <a ng-href="/#/members/addmany">
                                <i class="fa fa-upload"></i>
                                Cadastrar V&aacute;rios</a>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="javascript:;">
                        <i class="fa fa-suitcase"></i>
                        <span class="title">Carteiras</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">

                        <li>
                            <a ng-href="/#/carteiras">
                                <i class="icon-list"></i>
                                Listar</a>
                        </li>

                        <li>
                            <a ng-href="/#/carteiras/new">
                                <i class="fa fa-plus"></i>
                                Novo</a>
                        </li>

                        <li>
                            <a ng-href="/#/carteiras/addmany">
                                <i class="fa fa-upload"></i>
                                Cadastrar V&aacute;rios</a>
                        </li>
                    </ul>
                </li>



            </ul>

        </div>

    </div>

    <div class="page-content-wrapper" >
        <div class="page-content" ng-view></div>
    </div>

</div>


<!-- Scripts -->
@if(Config::get('app.debug'))
    <script src="{{asset('build/js/vendor/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/jquery.backstretch.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-route.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-resource.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-animate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-sanitize.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-messages.min.js')}}" type="text/javascript"></script>


    <script src="{{asset('build/js/vendor/toArrayFilter.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/ui-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/ui-bootstrap-tpls.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/select.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('build/js/vendor/angular-cookies.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/query-string.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-oauth2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-PapaParse.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/papaparse.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-slimscroll.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-datatables.bootstrap.min.js')}}" type="text/javascript"></script>




    <script src="{{asset('build/js/crm.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/routes/general.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/routes/admin-dashboard.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/routes/agenda-clientes.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/routes/painel-equipes.js')}}" type="text/javascript"></script>


    <!-- CONTROLLERS -->
    <script src="{{asset('build/js/controllers/login.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/logout.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/general.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/topmenu.js')}}" type="text/javascript"></script>

    <!-- CONTROLLERS: CLIENT -->
    <script src="{{asset('build/js/controllers/client/client.list.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/client/client.new.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/client/client.edit.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/client/client.remove.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/client/client.bulk.add.js')}}" type="text/javascript"></script>

    <!-- CONTROLLERS: TEAM -->
    <script src="{{asset('build/js/controllers/team/team.list.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/team/team.new.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/team/team.edit.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/team/team.remove.js')}}" type="text/javascript"></script>


    <!-- CONTROLLERS: MEMBER -->
    <script src="{{asset('build/js/controllers/member/member.list.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/member/member.new.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/member/member.edit.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/member/member.remove.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/member/member.addm.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/member/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/member/carteira.js')}}" type="text/javascript"></script>

    <!-- CONTROLLERS: PORTFOLIO -->
    <script src="{{asset('build/js/controllers/portfolio/portfolio.addm.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/portfolio/portfolio.new.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/portfolio/portfolio.list.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/portfolio/portfolio.remove.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/portfolio/portfolio.edit.js')}}" type="text/javascript"></script>


    <!-- CONTROLLERS: USER -->
    <script src="{{asset('build/js/controllers/user/user.list.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/user/user.new.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/user/user.edit.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/user/user.remove.js')}}" type="text/javascript"></script>

    <!-- CONTROLLERS: AGENDAMENTOS -->
    <script src="{{asset('build/js/controllers/agendamentos/atendimentos/agendamentos.atendimentos.js')}}" type="text/javascript"></script>

    <!-- CONTROLLERS: VENDAS -->
    <script src="{{asset('build/js/controllers/vendas/venda.aleatoria.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/vendas/venda.pedido.js')}}" type="text/javascript"></script>


    <!-- CONTROLLERS: CARTEIRA -->
    <script src="{{asset('build/js/controllers/carteira/carteira.edit.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/controllers/carteira/carteira.history.js')}}" type="text/javascript"></script>


    <!-- CONTROLLERS: STATUS -->
    <script src="{{asset('build/js/controllers/status/status.js')}}" type="text/javascript"></script>


    <!-- CONTROLLERS: LIDER -->
    <script src="{{asset('build/js/controllers/painel-equipe/painel-equipe.js')}}" type="text/javascript"></script>



    <!-- CONTROLLERS: CIP -->
    <script src="{{asset('build/js/controllers/cip/cip.js')}}" type="text/javascript"></script>

    <!-- FILTERS -->
    <script src="{{asset('build/js/filters/agendamento.js')}}" type="text/javascript"></script>

    <!-- SERVICES -->
    <script src="{{asset('build/js/services/client.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/team.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/member.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/user.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/user-group.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/portfolio.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/sale.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/status.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/cip.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/auth.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/auth-redirector.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/services/attendance.js')}}" type="text/javascript"></script>


    <!-------------------------------------------- DIRECTIVES --------------------------------------------------------->

    <script src="{{asset('build/js/directives/user/password-compare.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/directives/user/password-special.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/directives/user/username-verify.js')}}" type="text/javascript"></script>

    <!-- AGENDAMENTOS DIRECTIVES -->
    <script src="{{asset('build/js/directives/operador/agendamentos.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/directives/operador/carteiras.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/directives/operador/history.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/directives/operador/status.js')}}" type="text/javascript"></script>


    <!-- VENDAS DIRECTIVES -->
    <script src="{{asset('build/js/directives/vendas/venda.aleatoria.js')}}" type="text/javascript"></script>

    <!-- AGENDAMENTOS DIRECTIVES -->
    <script src="{{asset('build/js/directives/agendamentos/agendamentos.js')}}" type="text/javascript"></script>

@else
    <script src="{{elixir('js/all.js')}}" type="text/javascript"></script>
@endif

</body>
</html>