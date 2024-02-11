@extends('default', ['title' => 'Rifas'])
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

				<a href="{{ route('rifas.create') }}" class="btn btn-success ml-1 mb-3">
					<i class="la la-plus"></i> Cadastrar rifa
				</a>
				<a href="{{ route('premiacao.index') }}" class="btn btn-warning ml-1 mb-3">
					<i class="la la-gifts"></i> Cadastrar premiação
				</a>
				<h1 class="h3 mb-2 text-gray-800">Rifas</h1>

				

				<div class="row">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th></th>
									<th>#</th>
									<th>Descrição</th>
									<th>Ação</th>
								</tr>
							</thead>
							<tbody>
								@forelse($data as $item)
								<tr>
									<td><img class="round" src="/img_rifas/{{ $item->imagem }}"></td>
									<td>
										{{ $item->id }}
									</td>
									<td>
										{{ $item->descricao }}
									</td>
									<td>
										<form class="" action="{{ route('rifas.destroy', $item->id) }}" method="post"
											id="form-{{$item->id}}">
											@csrf
											@method('delete')
											<a class="dropdown-item text-warning" href="{{ route('rifas.edit', $item->id) }}"><i class="la la-edit"></i>Editar</a>

											<button type="button" class="dropdown-item btn-delete text-danger">
												<i class="la la-trash"></i>Remover
											</button>

											<a class="dropdown-item text-success" href="{{ route('rifas.kind', $item->id) }}"><i class="la la-check"></i>Sorteio</a>
										</form>
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4" class="text-center">Nenhum registro encontrado!</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>

				</div>
			</div>
			
		</div>
	</div>
</div>

@endsection

