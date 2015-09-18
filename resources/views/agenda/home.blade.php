<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"><![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"><![endif]-->
<!--[if !IE]>
<html lang="pt-Br">
<!--<![endif]-->

<head>
    <meta charset="utf-8"/>
    <title>Panpharma | CRM</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">


    @if(Config::get('app.debug'))
        <link href="{{ asset('build/css/vendor/bootstrap.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/bootstrap-theme.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/uniform.default.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/vendor/bootstrap-switch.min.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/layout.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/components.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/darkblue.css') }}" type="text/css" rel="stylesheet"/>
        <link href="{{ asset('build/css/todo.css') }}" type="text/css" rel="stylesheet"/>
    @else
        <link href="{{ elixir('css/all.css') }}" type="text/css" rel="stylesheet"/>
    @endif

</head>
<body class="page-full-width" data-ng-app="Crm">
<nav class="navbar navbar-default" role="navigation" bs-navbar>
    <div class="navbar-header">
        <a class="navbar-brand" href="#">CRM Panpharma</a>
    </div>
    <ul class="nav navbar-nav">
        <li data-match-route="/$"><a href="#/">Dashboard</a></li>
        <li data-match-route="/page-one"><a href="#/page-one">Clientes</a></li>
    </ul>
</nav>

<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content" data-ng-view>

        </div>
    </div>
</div>

<!-- Scripts -->
@if(Config::get('app.debug'))
    <script src="{{asset('build/js/vendor/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-route.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-resource.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-animate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/angular-messages.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/ui-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/vendor/navbar.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/modules/crm/Crm.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/modules/agenda/CrmAgenda.js')}}" type="text/javascript"></script>
    <script src="{{asset('build/js/modules/agenda/services/PortfolioFactory.js')}}" type="text/javascript"></script>
@else
    <script src="{{elixir('js/all.js')}}" type="text/javascript"></script>
@endif
</body>
</html>