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

                            <div class="pay-pendding">

                                <h2 style="color: #1974C7;">Atenção, permaneça nesta tela até aprovar o pagamento!</h2>

                                @foreach($data as $key => $i)
                                <label>Código {{$key+1}}</label><br>
                                <input style="text-align: center; font-size: 30px" type="" name="" value="{{$i->cupom}}"><br>
                                @endforeach
                                <br>

                                <h4>Valor total <strong style="color: #1974C7">R$ {{ number_format($item->rifa->valor*sizeof($data), 2, ',', '.')}}</strong></h4>
                                <br>
                                <img style="width: 300px; height: 300px; margin: auto;" src="data:image/jpeg;base64,{{$item->qr_code_base64}}"/>

                                <br>

                                <input style="width: 100% !important" type="text" class="form-control" value="{{$item->qr_code}}" id="qrcode_input" />
                                <br>
                                <button class="btn mt-1" type="button" onclick="copy()">Copiar linha digitável</button>
                            </div>

                            <div class="pay-approved" style="display: none;">
                                <img style="width: 300px; margin: auto" src="/img/success.png">
                                <h2>Obrigado seu pagamento foi confirmado!!</h2>
                            </div>
                            
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        function copy(){

            const inputTest = document.querySelector("#qrcode_input");

            inputTest.select();
            document.execCommand('copy');

            swal("", "Código pix copado!!", "success")
        }


        $(function(){
            console.clear()
            let refreshIntervalId = setInterval(() => {

                $.get('{{ route("pay.consulta-pix", $item->transacao_id) }}')
                .done((success) => {

                    console.log(success)
                    if(success == "approved"){
                        clearInterval(refreshIntervalId);
                        $('.pay-approved').css('display', 'block')
                        $('.pay-pendding').css('display', 'none')
                    }
                })
                .fail((err) => {
                    console.log(err)
                })
            }, 500)
        })

    </script>
</body>
</html>
