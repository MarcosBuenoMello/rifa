@extends('default', ['title' => 'Cadastrar cliente'])
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col-md-8">
						<h3 class="mb-0">Cadastrar cliente</h3>
					</div>
					<div class="col-md-4 text-right">
						<a href="{{ route('clientes.index') }}" class="btn btn-sm btn-primary">Voltar</a>
					</div>
				</div>
			</div>
			<div class="card-body">


				{!!Form::open()
				->post()
				->route('clientes.store')
				!!}
				<div class="pl-lg-4">
					@include('clientes._forms')
				</div>
				{!!Form::close()!!}

			</div>
		</div>
	</div>
</div>
@endsection