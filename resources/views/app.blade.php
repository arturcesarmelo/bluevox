<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Bluevox</title>

        <!-- App styles -->
        <link rel="stylesheet" type="text/css" href="/css/app.css"/>

        <!-- font awesome -->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    </head>
    <body style="max-width: 100%">
        <div id="app">
            @include('partials.navbar')
            @include('partials.sidebar')
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="/js/functions.js"></script>
    <script src="/js/app.js"></script>
    <script>
        $(document).ready(function(){
           
            toastr.options.onHidden = function() { 
                localStorage.setItem('created', false);
                localStorage.setItem('updated', false);
                localStorage.setItem('deleted', false);
            }

            if(localStorage.getItem('created') == true || localStorage.getItem('created') == "true") {
                toastr.success('cadastro criado com sucesso!');
            }

            if(localStorage.getItem('updated') == true || localStorage.getItem('updated') == "true") {
                toastr.success('cadastro atualizado com sucesso!');
            }
            if(localStorage.getItem('deleted') == true || localStorage.getItem('deleted') == "true") {
                toastr.success('cadastro deletado com sucesso!');
            }
        }) 
    </script>
</html>
