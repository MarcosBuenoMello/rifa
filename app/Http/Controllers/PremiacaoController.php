<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\PremioRifa;
use Illuminate\Support\Str;

class PremiacaoController extends Controller
{
    public function index(Request $request){
        $data = PremioRifa::
        orderBy('id', 'desc')
        ->when(!empty($request->rifa_id), function ($q) use ($request) {
            return $q->where('rifa_id', $request->rifa_id);
        })
        ->get();

        $rifas = Rifa::orderBy('status', 'desc')
        ->orderBy('id', 'desc')
        ->get();

        return view('premio_rifas.index', compact('data', 'rifas'));
    }

    public function create(){
        $rifas = Rifa::orderBy('status', 'desc')
        ->orderBy('id', 'desc')
        ->get();
        return view('premio_rifas.create', compact('rifas'));
    }

    public function edit($id){
        $item = PremioRifa::findOrFail($id);
        $rifas = Rifa::orderBy('status', 'desc')
        ->orderBy('id', 'desc')
        ->get();
        return view('premio_rifas.edit', compact('item', 'rifas'));
    }

    public function store(Request $request){
        try{

            if(!is_dir(public_path('img_premio_rifas'))){
                mkdir(public_path('img_premio_rifas'), 0777, true);
            }

            $fileName = "";
            if($request->hasFile('file')){
                $file = $request->file('file');

                $fileName = Str::random(20) . "." . $file->getClientOriginalExtension();
                $file->move(public_path('img_premio_rifas'), $fileName);

            }
            $request->merge([
                'imagem' => $fileName
            ]);

            PremioRifa::create($request->all());
            session()->flash("flash_sucesso", "Registro criado!");

        }catch(\Exception $e){
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());
        }
        return redirect()->route('premiacao.index');
    }

    public function update(Request $request, $id){
        try{
            $item = PremioRifa::findOrFail($id);
            $fileName = $item->imagem;
            if($request->hasFile('file')){
                $file = $request->file('file');

                $path = public_path('img_premio_rifas/'). $item->imagem;
                if(file_exists($path)){
                    unlink($path);
                }

                $fileName = Str::random(20) . "." . $file->getClientOriginalExtension();
                $file->move(public_path('img_premio_rifas'), $fileName);

            }
            $request->merge([
                'imagem' => $fileName
            ]);

            $item->fill($request->all())->save();
            session()->flash("flash_sucesso", "Registro atualizado!");

        }catch(\Exception $e){
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());
        }
        return redirect()->route('premiacao.index');
    }

    public function destroy($id){
        $item = PremioRifa::findOrFail($id);

        try {

            $path = public_path('img_premio_rifas/') . $item->imagem;
            if(file_exists($path)){
                unlink($path);
            }

            $item->delete();
            session()->flash("flash_sucesso", "Registro removido");

        } catch (\Exception $e) {
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());

        }
        return redirect()->route('premiacao.index');

    }
}
