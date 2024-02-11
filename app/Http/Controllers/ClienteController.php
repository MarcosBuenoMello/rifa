<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
class ClienteController extends Controller
{
    public function index(Request $request){
        $data = Cliente::orderBy('nome', 'asc')
        ->get();

        return view('clientes.index', compact('data'));
    }

    public function create(){
        return view('clientes.create');
    }

    public function edit($id){
        $item = Cliente::findOrFail($id);
        return view('clientes.edit', compact('item'));
    }

    public function store(Request $request){
        try{

            Cliente::create($request->all());
            session()->flash("flash_sucesso", "Registro criado!");

        }catch(\Exception $e){
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());
        }
        return redirect()->route('clientes.index');
    }

    public function update(Request $request, $id){
        try{
            $item = Cliente::findOrFail($id);

            $item->fill($request->all())->save();
            session()->flash("flash_sucesso", "Registro atualizado!");

        }catch(\Exception $e){
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());
        }
        return redirect()->route('clientes.index');
    }

    public function destroy($id){
        $item = Cliente::findOrFail($id);

        try {

            $item->delete();
            session()->flash("flash_sucesso", "Registro removido");

        } catch (\Exception $e) {
            session()->flash("flash_erro", "Algo errado: " . $e->getMessage());

        }
        return redirect()->route('clientes.index');

    }
}
