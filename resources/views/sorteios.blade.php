<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rifa Solidária</title>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" href="/solid/css/style.css">
    <script src="https://unpkg.com/animejs@3.0.1/lib/anime.min.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>

    <style type="text/css">
        img .rifa{
            height: 10px !important;
        }
        .mt-1{
            margin-top: 5px;
        }

        .btn{

        }

        .btn {
            background-color: #c2fbd7;
            border-radius: 100px;
            box-shadow: rgba(44, 187, 99, .2) 0 -25px 18px -14px inset,rgba(44, 187, 99, .15) 0 1px 2px,rgba(44, 187, 99, .15) 0 2px 4px,rgba(44, 187, 99, .15) 0 4px 8px,rgba(44, 187, 99, .15) 0 8px 16px,rgba(44, 187, 99, .15) 0 16px 32px;
            color: green;
            cursor: pointer;
            display: inline-block;
            font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
            padding: 7px 20px;
            text-align: center;
            text-decoration: none;
            transition: all 250ms;
            border: 0;
            font-size: 16px;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .btn:hover {
            box-shadow: rgba(44,187,99,.35) 0 -25px 18px -14px inset,rgba(44,187,99,.25) 0 1px 2px,rgba(44,187,99,.25) 0 2px 4px,rgba(44,187,99,.25) 0 4px 8px,rgba(44,187,99,.25) 0 8px 16px,rgba(44,187,99,.25) 0 16px 32px;
            transform: scale(1.05) rotate(-1deg);
        }
        .header-logo-image{
            width: 100px;
        }
    </style>
</head>
<body class="is-boxed has-animations">
    <div class="body-wrap">
        <header class="site-header">
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0"><a href="/">
                            <img class="header-logo-image" src="/img/logo.png" alt="Logo">
                        </a></h1>
                    </div>
                </div>
            </div>
        </header>

        <main>

            <section class="pricing section">
                <div class="container-sm">
                    <div class="pricing-inner section-inner">
                        <div class="pricing-header text-center">

                            
                            <br>

                            @if(sizeof($data) == 0)
                            <form method="get" action="">
                                <h5>Informe abaixo o email ou cpf para filtrar</h5>
                                <input type="email" class="form-control mt-1" placeholder="Email" name="email"><br>
                                <input type="tel" data-mask="000.000.000-00" class="form-control mt-1" placeholder="CPF" name="cpf"><br>
                                
                                <button class="btn mt-1" type="submit">Filtrar</button>
                            </form>
                            @else

                            <table>
                                <thead>
                                    <tr>
                                        <th>Data de sorteio</th>
                                        <th>Data da compra</th>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->rifa->data_sorteio)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $item->cupom }}</td>
                                        <td>{{ $item->rifa->descricao }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @endif
                            
                        </div>
                        
                    </div>
                </div>
            </section>

        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="site-footer-inner">
                    <div class="brand footer-brand">
                        <a href="#">
                            <img class="header-logo-image" src="/img/logo.png" alt="Logo">
                        </a>
                    </div>

                    <ul class="footer-social-links list-reset">

                    </ul>
                    <div class="footer-copyright">&copy; {{date('Y')}} Rifa, todos os direitos reservados</div>
                </div>
            </div>
        </footer>
    </div>

    <script src="/solid/js/main.min.js"></script>
    <script src="/vendor/jquery/jquery.min.js"></script>

    <script type="text/javascript" src="/js/jquery.mask.min.js"></script>
</body>
</html>
