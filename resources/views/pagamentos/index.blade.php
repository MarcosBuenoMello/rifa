@extends('default', ['title' => 'Pagamentos'])
@section('content')

<style type="text/css">
	.img-profile{
		height: 120px;
		width: auto;
	}
</style>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">

				<a href="{{ route('pagamentos.create') }}" class="btn btn-success ml-1 mb-3">
					<i class="la la-money"></i> Pagamento manual
				</a>

				<a href="{{ route('pagamentos.refresh') }}" class="btn btn-danger ml-1 mb-3 btn-refresh">
					<i class="la la-refresh"></i> Verificar pagamentos
				</a>

				{!!Form::open()->fill(request()->all())
				->get()
				!!}
				<div class="row ml-3 mt-2 mr-2">
					<div class="col-md-3">
						{!!Form::select('cliente_id', 'Cliente', [null => 'Selecione...'] + $clientes->pluck('info',
						'id')->all())
						->attrs(['class' => 'select2'])
						!!}
					</div>

					<div class="col-md-3">
						{!!Form::select('rifa_id', 'Rifa', [null => 'Selecione...'] + $rifas->pluck('descricao',
						'id')->all())
						->attrs(['class' => 'select2'])
						!!}
					</div>

					<div class="col-md-3">
						{!!Form::select('status', 'Status de pagamento', [null => 'Selecione...'] + ['approved' => 'Aprovados', 'pending' => 'Pendente'])
						->attrs(['class' => 'select2'])
						!!}
					</div>

					<div class="col-md-2 text-left mt-1">
						<br>
						<button class="btn btn-sm  btn-primary" style="font-size: 9px;" type="submit"><svg
							xmlns="http://www.w3.org/2000/svg" width="9" height="9" fill="currentColor"
							class="bi bi-funnel-fill" viewBox="0 0 16 16">
							<path
							d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z" />
						</svg> Filtrar</button>
						<a id="clear-filter" style="font-size: 9px;" class="btn btn-sm btn-danger"
						href="{{ route('mensalidade.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="9"
						height="9" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
						<path
						d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" /></svg> Limpar</a>
					</div>
				</div>

				<div class="col-12 mt-2"></div>
				{!!Form::close()!!}
				
				<h1 class="h3 mb-2 text-gray-800">Pagamentos</h1>

				<div class="row">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Cliente</th>
									<th>Rifa</th>
									<th>Data de pagamento</th>
									<th>Status</th>
									<th>Valor</th>
									<th>Ação</th>
								</tr>
							</thead>
							<tbody>
								@forelse($data as $item)
								
								<tr>
									<td>
										{{ $item->id }}
									</td>
									<td>
										{{ $item->cliente->nome }} - {{ $item->cliente->whatsApp }}
									</td>
									<td>
										{{ $item->rifa->descricao }}
									</td>
									<td>
										{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}
									</td>
									<td>
										{{ strtoupper($item->status_pagamento) }}
									</td>

									<td>
										R$ {{ number_format($item->rifa->valor, 2, ',', '.') }}
									</td>
									<td>
										<form class="" action="{{ route('pagamentos.destroy', $item->id) }}" method="post"
											id="form-{{$item->id}}">
											@csrf
											@method('delete')

											<button type="button" class="dropdown-item btn-delete text-danger">
												<i class="la la-trash"></i>Remover
											</button>
										</form>
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="5" class="text-center">Nenhum registro encontrado!</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>

					<h4>Soma: <strong>R$ {{ number_format($sum, 2, ',', '.') }}</strong></h4>

				</div>
			</div>

			 <div style="overflow: auto" class="my-4 mx-3 row">
                <nav class="d-flex ml-auto" aria-label="...">
                    {{ $data->appends(request()->all())->links() }}
                </nav>
            </div>
			
		</div>
	</div>
</div>

@endsection

@section('js')
<script type="text/javascript">
	$('.btn-refresh').click(() => {
		$('#loading-page').show(0)
	})
</script>
@endsection

