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
        .img-round{
            border-radius: 50%;
            border: 3px solid #102E4D;
            height: 200px;
            width: 200px;
        }
        .mini-icon{
            border-radius: 50%;
            height: 30px;
            margin-right: 5px;
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
                        <h1 class="m-0"><a href="#">
                            <img class="header-logo-image" src="/img/logo.png" alt="Logo">
                        </a></h1>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container">
                    <div class="hero-inner">
                        <div class="hero-copy">
                            <h1 class="hero-title mt-0">Rifa Solidária</h1>
                            <p class="hero-paragraph">Está rifa esta direcionada a ajudar aos atletas do esporte jiu-jitsu a representarem a cidade em campeonatos da modalidade esportiva em questão. </p>
                            <div class="hero-cta">
                                <a class="button button-primary" href="/sorteios">Minhas compras</a>
                                <a class="button" href="#rifas">Rifas disponíveis</a></div>
                            </div>
                            <div class="hero-figure anime-element">
                               <svg class="placeholder" width="528" height="396" viewBox="0 0 528 396">
                                <rect width="528" height="396" style="fill:transparent;" />
                            </svg>
                            <div class="hero-figure-box hero-figure-box-01" data-rotation="45deg"></div>
                            <div class="hero-figure-box hero-figure-box-02" data-rotation="-45deg"></div>
                            <div class="hero-figure-box hero-figure-box-03" data-rotation="0deg"></div>
                            <div class="hero-figure-box hero-figure-box-04" data-rotation="-135deg"></div>
                            <div class="hero-figure-box hero-figure-box-05"></div>
                            <div class="hero-figure-box hero-figure-box-06"></div>
                            <div class="hero-figure-box hero-figure-box-07"></div>
                            <div class="hero-figure-box hero-figure-box-08" data-rotation="-22deg"></div>
                            <div class="hero-figure-box hero-figure-box-09" data-rotation="-52deg"></div>
                            <div class="hero-figure-box hero-figure-box-10" data-rotation="-50deg"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="features section">
                <div class="container">
                    <div class="features-inner section-inner has-bottom-divider">
                        <div class="features-wrap">
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img class="img-round" src="/img/cesa.jpeg" alt="Feature 01">
                                    </div>
                                    <h4 class="feature-title mt-24">Ylber Cesa</h4>
                                    
                                </div>
                            </div>
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img class="img-round" src="/img/thiago.png" alt="Feature 01">
                                    </div>
                                    <h4 class="feature-title mt-24">Thiago Carvalho</h4>
                                </div>
                            </div>
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img class="img-round" src="/img/kaik.jpeg" alt="Feature 01">
                                    </div>
                                    <h4 class="feature-title mt-24">Kaik Souza</h4>
                                </div>
                            </div>
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img class="img-round" src="/img/wesley.jpeg" alt="Feature 01">
                                    </div>
                                    <h4 class="feature-title mt-24">Wesley Willian</h4>
                                </div>
                            </div>
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img class="img-round" src="/img/marcos.png" alt="Feature 01">
                                    </div>
                                    <h4 class="feature-title mt-24">Marcos Mello</h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>

            <section class="pricing section" id="rifas">
                @foreach($data as $item)
                <div class="container-sm">
                    <div class="pricing-inner section-inner">
                        <div class="pricing-header text-center">


                        </div>
                        <div class="pricing-tables-wrap">
                            <div class="pricing-table">
                                <div class="pricing-table-inner is-revealing">
                                    <div class="pricing-table-main">
                                        <div class="pricing-table-header pb-24">
                                            <div class="pricing-table-price"><span class="pricing-table-price-currency h2">R$</span><span class="pricing-table-price-amount h1">
                                                {{ number_format($item->valor, 2, ',', '.') }}
                                            </span><span class="text-xs"></span></div>

                                            <span>Data do sorteio <strong>{{ \Carbon\Carbon::parse($item->data_sorteio)->format('d/m/Y')}}</strong></span>
                                        </div>
                                        <div class="pricing-table-features-title text-xs pt-24 pb-24">
                                            {{$item->descricao}}
                                        </div>
                                        <ul class="pricing-table-features list-reset text-xs">
                                            @foreach($item->premios as $p)
                                            <li>
                                                <img class="mini-icon" src="/img_premio_rifas/{{$p->imagem}}">
                                                <span>{{ $p->descricao }}</span>
                                            </li>
                                            @endforeach
                                            

                                        </ul>
                                    </div>
                                    <div class="pricing-table-cta mb-8">
                                        <a class="button button-primary button-shadow button-block" href="/pay/{{$item->id}}">Comprar agora</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
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
                    <div class="footer-copyright">&copy; {{date('Y')}} Rifa, todos os direitos reservados slym</div>
                </div>
            </div>
        </footer>
    </div>

    <script src="/solid/js/main.min.js"></script>
</body>
</html>
