@extends('default', ['title' => 'Cadastrar rifa'])
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col-md-8">
						<h3 class="mb-0">Cadastrar rifa</h3>
					</div>
					<div class="col-md-4 text-right">
						<a href="{{ route('rifas.index') }}" class="btn btn-sm btn-primary">Voltar</a>
					</div>
				</div>
			</div>
			<div class="card-body">


				{!!Form::open()
				->post()
				->route('rifas.store')
				->multipart()!!}
				<div class="pl-lg-4">
					@include('rifas._forms')
				</div>
				{!!Form::close()!!}

			</div>
		</div>
	</div>
</div>
@endsection