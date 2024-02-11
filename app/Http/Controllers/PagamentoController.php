<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteRifa;
use App\Models\Rifa;
use App\Models\Cliente;

class PagamentoController extends Controller
{
    public function index(Request $request){
        $data = ClienteRifa::
        orderBy('id', 'desc')
        ->join('rifas', 'rifas.id', '=', 'cliente_rifas.rifa_id')
        ->select('cliente_rifas.*', 'rifas.valor')
        ->when(!empty($request->rifa_id), function ($q) use ($request) {
            return $q->where('rifa_id', $request->rifa_id);
        })
        ->when(!empty($request->cliente_id), function ($q) use ($request) {
            return $q->where('cliente_id', $request->cliente_id);
        })
        ->when(!empty($request->status), function ($q) use ($request) {
            return $q->where('status_pagamento', $request->status);
        })
        ->paginate(50);

        $rifas = Rifa::orderBy('status', 'desc')
        ->orderBy('id', 'desc')
        ->get();

        $clientes = Cliente::orderBy('nome', 'asc')
        ->get();

        $sum = ClienteRifa::
        join('rifas', 'rifas.id', '=', 'cliente_rifas.rifa_id')
        ->select('cliente_rifas.*', 'rifas.valor')
        ->sum('rifas.valor');

        return view('pagamentos.index', compact('data', 'rifas', 'clientes', 'sum'));
    }

    public function create(){
        $rifas = Rifa::orderBy('status', 'desc')
        ->orderBy('id', 'desc')
        ->get();

        $clientes = Cliente::orderBy('nome', 'asc')
        ->get();

        $cupom = '';
        do{
            $cupom = $this->getRandom(6);
            $tc = ClienteRifa::where('cupom', $cupom)->first();
        }while($tc != null);

        return view('pagamentos.create', compact('rifas', 'clientes', 'cupom'));

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

    public function store(Request $request){

        try{
            $dataClienteRifa = [
                'cliente_id' => $request->cliente_id,
                'rifa_id' => $request->rifa_id,
                'qr_code_base64' => '',
                'qr_code' => '',
                'transacao_id' => '',
                'status_pagamento' => 'approved',
                'cupom' => $request->cupom
            ];

            ClienteRifa::create($dataClienteRifa);
            session()->flash("flash_sucesso", "Pagamento registrado!");
        }catch(\Exception $e){
            echo $e->getMessage();
            die;
            session()->flash("flash_erro", "algo deu errado: " . $e->getMessage());

        }
        return redirect()->route('pagamentos.index');

    }

    public function destroy($id){
        $item = ClienteRifa::findOrFail($id);

        try {

            $item->delete();
            session()->flash("flash_sucesso", "Registro removido");

        } catch (\Exception $e) {
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());

        }
        return redirect()->route('pagamentos.index');

    }

    public function refresh(){
        $data = ClienteRifa::where('qr_code', '!=', '')
        ->limit(150)
        ->orderBy('id', 'desc')
        ->get();
        \MercadoPago\SDK::setAccessToken(getenv("MERCADOPAGO_ACCESS_TOKEN_PRODUCAO"));

        foreach($data as $item){
            $payStatus = \MercadoPago\Payment::find_by_id($item->transacao_id);
            // echo $payStatus->status . "<br>";
            $item->status_pagamento = $payStatus->status;
            $item->save();
        }
        session()->flash("flash_sucesso", "Pagamentos atualizados");
        return redirect()->route('pagamentos.index');

    }
}
