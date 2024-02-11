<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\ClienteRifa;
use App\Models\Premiacao;
use Illuminate\Support\Str;

class RifaController extends Controller
{
    public function index(Request $request){
        $data = Rifa::orderBy('status', 'desc')
        ->orderBy('id', 'desc')
        ->get();

        return view('rifas.index', compact('data'));
    }

    public function create(){
        return view('rifas.create');
    }

    public function edit($id){
        $item = Rifa::findOrFail($id);
        return view('rifas.edit', compact('item'));
    }

    public function store(Request $request){
        try{

            if(!is_dir(public_path('img_rifas'))){
                mkdir(public_path('img_rifas'), 0777, true);
            }

            $fileName = "";
            if($request->hasFile('file')){
                $file = $request->file('file');

                $fileName = Str::random(20) . "." . $file->getClientOriginalExtension();
                $file->move(public_path('img_rifas'), $fileName);

            }
            $request->merge([
                'observacao' => $request->observacao ?? '',
                'valor' => __replace($request->valor),
                'imagem' => $fileName
            ]);

            Rifa::create($request->all());
            session()->flash("flash_sucesso", "Registro criado!");

        }catch(\Exception $e){
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());
        }
        return redirect()->route('rifas.index');
    }

    public function update(Request $request, $id){
        try{
            $item = Rifa::findOrFail($id);
            $fileName = $item->imagem;
            if($request->hasFile('file')){
                $file = $request->file('file');

                $path = public_path('img_rifas/'). $item->imagem;
                if(file_exists($path)){
                    unlink($path);
                }

                $fileName = Str::random(20) . "." . $file->getClientOriginalExtension();
                $file->move(public_path('img_rifas'), $fileName);

            }
            $request->merge([
                'observacao' => $request->observacao ?? '',
                'valor' => __replace($request->valor),
                'imagem' => $fileName
            ]);

            $item->fill($request->all())->save();
            session()->flash("flash_sucesso", "Registro atualizado!");

        }catch(\Exception $e){
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());
        }
        return redirect()->route('rifas.index');
    }

    public function destroy($id){
        $item = Rifa::findOrFail($id);

        try {

            $path = public_path('img_rifas/') . $item->imagem;
            if(file_exists($path)){
                unlink($path);
            }

            $item->delete();
            session()->flash("flash_sucesso", "Registro removido");

        } catch (\Exception $e) {
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());

        }
        return redirect()->route('rifas.index');

    }

    public function kind($id){
        $vendidos = ClienteRifa::select('cupom')
        ->where('status_pagamento', 'approved')
        ->get();
        $cupons = [];
        foreach($vendidos as $v){
            array_push($cupons, $v->cupom);
        }
        $item = Rifa::findOrFail($id);
        return view('rifas.kind', compact('item', 'cupons'));
    }

    public function getGanhador($cupom){
        try{
            $item = ClienteRifa::with('cliente')->where('cupom', $cupom)->first();
            return response()->json($item, 200);
        }catch(\Exception $e){
            return response()->json("ok", 401);
        }
    }

    public function kindSave(Request $request, $id){
        $item = Rifa::findOrFail($id);
        for($i=0; $i<sizeof($request->numero); $i++){
            $rifa = ClienteRifa::where('cupom', $request->numero[$i])->first();
            Premiacao::create([
                'cliente_id' => $rifa->cliente_id,
                'premio_id' => $request->premio_id[$i],
                'observacao' => ""
            ]);
        }
        session()->flash("flash_sucesso", "Rifa finalizada");
        return redirect()->route('rifas.index');
    }

}
