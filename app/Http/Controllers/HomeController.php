<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\Cliente;
use App\Models\ClienteRifa;
use Illuminate\Support\Str;
use Mail;

class HomeController extends Controller
{
    public function index(){
        $data = Rifa::orderBy('created_at', 'desc')->get();
        return view('site', compact('data'));
    }

    public function pay($id){
        $item = Rifa::findOrFail($id);
        if($item->status){
            return view('pay', compact('item'));
        }else{
            return redirect()->back();
        }
    }

    public function qrcode(Request $request){

        \MercadoPago\SDK::setAccessToken(getenv("MERCADOPAGO_ACCESS_TOKEN_PRODUCAO"));
        $payment = new \MercadoPago\Payment();

        $item = Rifa::findOrFail($request->rifa_id);

        $valor = $item->valor * $request->qtd;

        $payment->transaction_amount = (float)$valor;
        $payment->description = 'Pagamento de rifa ' . $request->nome;
        $payment->payment_method_id = "pix";

        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);

        $dataCliente = [
            'nome' => $request->nome,
            'cpf' => $cpf,
            'whatsApp' => $request->whatsApp,
            'email' => $request->email
        ];

        $tstCli = Cliente::where('cpf', $cpf)->first();

        if($tstCli == null){
            $cli = Cliente::updateOrCreate($dataCliente);
        }else{
            $cli = $tstCli;
        }

        $payment->payer = array(
            "email" => $request->email,
            "first_name" => $request->nome,
            "last_name" => "bjj",
            "identification" => array(
                "type" => 'CPF',
                "number" => $cpf
            ),
            "address"=>  array(
                "zip_code" => getenv("CEP"),
                "street_name" => getenv("RUA"),
                "street_number" => getenv("NUMERO"),
                "neighborhood" => getenv("BAIRRO"),
                "city" => getenv("CIDADE"),
                "federal_unit" => getenv("UF")
            )
        );

        $payment->save();
        if($payment->transaction_details){
            $qtd = $request->qtd;
            $cupoms = [];
            for($i=0; $i< $qtd; $i++){
                do{
                    $cupom = $this->getRandom(6);
                    $tc = ClienteRifa::where('cupom', $cupom)->first();
                }while($tc != null);
                array_push($cupoms, $cupom);
            }

            foreach($cupoms as $c){            
                $dataClienteRifa = [
                    'cliente_id' => $cli->id,
                    'rifa_id' => $item->id,
                    'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64,
                    'qr_code' => $payment->point_of_interaction->transaction_data->qr_code,
                    'transacao_id' => $payment->id,
                    'status_pagamento' => $payment->status,
                    'cupom' => $c
                ];
                echo $c . "<br>";
                ClienteRifa::create($dataClienteRifa);

            }

            session()->flash("flash_sucesso", "Tudo certo, escaneie o QrCode ou copie a chave para finalizar");

            return redirect('/finish/'.$payment->id);
        }else{
            // echo $payment->error->message;
            // die;
            session()->flash("flash_erro", "Ocorreu um erro no pagamento: " . $payment->error->message);
            return redirect()->back();
        }
    }

    private function getRandom($n) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function finish($transaction_id){
        $data = ClienteRifa::where('transacao_id', $transaction_id)
        ->get();

        if($data){
            $item = $data[0];
            return view('finish', compact('data', 'item'));
        }else{
            session()->flash("flash_erro", "Algo errado ao localizar transação!");
            return redirect('/');
        }
    }

    public function consultaPIX($transaction_id){

        try{

            $data = ClienteRifa::where('transacao_id', $transaction_id)
            ->get();

            $item = $data[0];

            \MercadoPago\SDK::setAccessToken(getenv("MERCADOPAGO_ACCESS_TOKEN_PRODUCAO"));
            $payStatus = \MercadoPago\Payment::find_by_id($transaction_id);
            // $payStatus->status = "approved";
            if($payStatus->status != $item->status_pagamento && $payStatus->status == "approved"){
                foreach($data as $d){
                    $d->status_pagamento = $payStatus->status;
                    $d->save();
                }
                $this->sendMail($data);
            }

            return response()->json($payStatus->status, 200);

        }catch(\Exception $e){
            return response()->json($e->getMessage(), 401);
        }
    }

    public function sorteios(Request $request){

        $data = [];
        $cliente = null;
        if($request->email){
            $cliente = Cliente::where('email', $request->email)->first();
        }
        if($request->cpf){
            $cpf = preg_replace('/[^0-9]/', '', $request->cpf);
            $cliente = Cliente::where('cpf', $cpf)->first();
        }

        if($cliente != null){
            $data = ClienteRifa::where('cliente_id', $cliente->id)
            ->where('status_pagamento', 'approved')
            ->orderBy('created_at', 'desc')->get();
        }

        return view('sorteios', compact('data'));
    }

    private function sendMail($data){
        try{
            Mail::send('email.confirmacao', ['rifa' => $data[0], 'data' => $data], function($m) use($rifa){

                $m->from(getenv('MAIL_USERNAME'), getenv("MAIL_FROM_NAME"));
                $m->subject('Pedido realizado ' . getenv("MAIL_FROM_NAME"));
                $m->to($rifa->cliente->email);
            });
            return true;

        }catch(\Exception $e){
            return false;
        }
    }
}
