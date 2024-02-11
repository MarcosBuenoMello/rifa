<div class="row">
    <div class="col-md-3">
        {!!Form::text('nome', 'Nome')
        ->required()
        !!}
    </div>
    <div class="col-md-2">
        {!!Form::text('cpf', 'CPF')
        ->attrs(['class' => 'cpf'])
        ->required()
        !!}
    </div>

    <div class="col-md-3">
        {!!Form::text('whatsApp', 'WhatsApp')
        ->attrs(['class' => 'celular'])
        ->required()
        !!}
    </div>

    <div class="col-md-4">
        {!!Form::text('email', 'Email')
        ->required()
        ->type('email')
        !!}
    </div>

    
</div>
<div class="row">
    <div class="col-12">
        <button type="submit" class="btn btn-success float-right mt-4">Salvar</button>
    </div>
</div>