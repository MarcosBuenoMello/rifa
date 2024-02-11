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

                            <div class="feature-icon">
                                <img style="height: 200px; border-radius: 10px;" src="/img_rifas/{{$item->imagem}}">
                            </div>
                            <h2 class="section-title mt-2">{{$item->descricao}}</h2>
                            <p class="section-paragraph mb-0">
                                {{$item->observacao}}
                            </p>
                            <br>
                            <form method="post" action="{{ route('pay.qrcode') }}">
                                <input type="hidden" name="rifa_id" value="{{$item->id}}">
                                @csrf
                                <label>Nome</label><br>
                                <input required type="text" class="form-control mt-1" placeholder="Nome" name="nome"><br>
                                <label>CPF</label><br>
                                <input required type="tel" data-mask="000.000.000-00" class="form-control mt-1" placeholder="CPF" name="cpf"><br>
                                <label>Email</label><br>
                                <input required type="email" class="form-control mt-1" placeholder="Email" name="email"><br>
                                <label>WhatsApp</label><br>
                                <input required type="tel" data-mask="(00) 00000-0000" class="form-control mt-1" placeholder="WhatsApp" name="whatsApp"><br>
                                <label>Quantidade de rifas</label><br>
                                <input required type="tel" data-mask="00" value="1" class="form-control mt-1" placeholder="Quantidade de rifas" name="qtd"><br>
                                <button class="btn mt-1" type="submit">Gerar QrCode</button>
                            </form>
                            
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
