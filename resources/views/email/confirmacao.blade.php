<h3>Olá, {{$rifa->cliente->nome}}</h3>

<h5>Seu pedido foi confirmado, obrigado!</h5>

<h5>Cupom(ns)</h5>

@foreach($data as $c) 
<h6>{{$c->cupom}}</h6>
@endforeach

<h4>Att, {{getenv("APP_NAME")}}</h4>