@extends('default', ['title' => 'Sorteio'])
@section('content')
<style type="text/css">
	.img-round{
		border-radius: 50%;
		border: 3px solid #102E4D;
		height: 200px;
		width: 200px;
	}
	.mini-icon{
		height: 100px;
	}

	.premio p{
		font-size: 30px;
	}

	.info{
		font-size: 30px;
		color: #4B476D;
	}
</style>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col-md-8">
						<h3 class="mb-0">Sorteio</h3>
					</div>
					<div class="col-md-4 text-right">
						<a href="{{ route('rifas.index') }}" class="btn btn-sm btn-primary">Voltar</a>
					</div>
				</div>
			</div>
			<div class="card-body">


				{!!Form::open()
				->put()
				->route('rifas.kind-save', [$item->id])!!}
				<div class="pl-lg-4">

					@foreach($item->premios as $p)
					<div class="row premio mt-3">
						<div class="col-6 col-lg-3">
							<img class="mini-icon" src="/img_premio_rifas/{{$p->imagem}}">
							
						</div>
						<div class="col-6 col-lg-5">
							<p>{{ $p->descricao }}</p>
						</div>
						<div class="col-6 col-lg-2">
							<button type="button" onclick="kind('{{$p->id}}')" class="btn btn-info btn-kind">Sortear</button>
						</div>
						<div class="col-6 col-lg-2">
							<input required id="numero_{{$p->id}}" class="form-control" data-mask="" type="" name="numero[]">
						</div>
						<input type="hidden" name="premio_id[]" value="{{$p->id}}">
					</div>
					<div class="info_{{$p->id}} info mt-2">
						
					</div>
					<hr>
					@endforeach

					<button class="btn btn-success">
						Salvar Premiação
					</button>
				</div>

				{!!Form::close()!!}
				<input type="hidden" value="{{json_encode($cupons)}}" id="cupons">
			</div>
		</div>
	</div>
</div>

@section('js')
<script type="text/javascript">

	var CUPONS = []
	$(function(){
		CUPONS = JSON.parse($('#cupons').val())
		console.clear()
	})
	function kind(premio_id){
		$('.btn-kind').attr('disabled', 'disabled')
		$('.info_'+premio_id).html('<center><p>Sorteando...</p></center>')
		let myTimer = setInterval(() => {
			$('#numero_'+premio_id).val(CUPONS[parseInt(Math.random() * CUPONS.length)])
		}, 100)

		setTimeout(() => {
			clearInterval(myTimer);
			setTimeout(() => {
				let cupom = $('#numero_'+premio_id).val()
				getGanhador(cupom, premio_id)
				$('.btn-kind').removeAttr('disabled')
				$('.info_'+premio_id).html('')

			}, 10)
		}, 5000)

	}

	function getGanhador(cupom, premio_id){
		var url = window.location.protocol + "//" + window.location.host 
		$.get(url+"/api/getGanhador/"+cupom)
		.done((res) => {
			console.log(res)
			let nome = res.cliente.nome
			let cpf = res.cliente.cpf
			let whatsApp = res.cliente.whatsApp

			$('.info_'+premio_id).html('<center><p>'+nome+'</p></center>')
			$('.info_'+premio_id).append('<center><p>'+whatsApp+'</p></center>')
			// $('.info_'+premio_id).append('<center><p>'+cpf+'</p></center>')
			removeCupomArray(cupom)
		})
		.fail((err) => {
			console.log(err)
		})
	}

	function removeCupomArray(cupom){
		let temp = CUPONS.filter((x) => {
			return x != cupom
		})
		setTimeout(() => {
			CUPONS = temp
		}, 100)
	}
</script>
@endsection
@endsection