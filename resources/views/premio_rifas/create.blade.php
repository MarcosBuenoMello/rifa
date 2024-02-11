@extends('default', ['title' => 'Cadastrar premiação'])
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col-md-8">
						<h3 class="mb-0">Cadastrar premiação</h3>
					</div>
					<div class="col-md-4 text-right">
						<a href="{{ route('premiacao.index') }}" class="btn btn-sm btn-primary">Voltar</a>
					</div>
				</div>
			</div>
			<div class="card-body">


				{!!Form::open()
				->post()
				->route('premiacao.store')
				->multipart()!!}
				<div class="pl-lg-4">
					@include('premio_rifas._forms')
				</div>
				{!!Form::close()!!}

			</div>
		</div>
	</div>
</div>
@endsection