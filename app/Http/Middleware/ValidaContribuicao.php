<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Models\Contribuicao;

class ValidaContribuicao
{
	public function handle($request, Closure $next){
		$value = session('user_logged');

		if($value['master']){
			return $next($request);
		}
		$aluno = $value['aluno'];

		$pag = Contribuicao::
		whereMonth('created_at', date('m'))
		->whereYear('created_at', date('Y'))
		->where('aluno_id', $aluno->id)
		->where('status', 'approved')
		->first();

		// $mesCadastro = \Carbon\Carbon::parse($aleuno->created_at)->format('m');
		// if(date('m') == $mesCadastro){
		// 	return $next($request);
		// }

		$hoje = date('d');

		if($pag == null && $hoje >= 15){
			session()->flash("flash_erro", "Acesso bloqueado, realize o pagamento da contribuição!");
			return redirect('/contribuicao/create');
		}

		return $next($request);

	}

}