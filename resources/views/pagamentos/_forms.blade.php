<div class="row">
    <div class="col-md-2">
        {!!Form::tel('cupom', 'Cupom')
        ->required()
        ->readonly()
        ->value($cupom)
        !!}
    </div>

    <div class="col-md-3">
        {!!Form::select('cliente_id', 'Cliente', [null => 'Selecione...'] + $clientes->pluck('info',
        'id')->all())
        ->attrs(['class' => 'select2'])
        ->required()
        !!}
    </div>

    <div class="col-md-3">
        {!!Form::select('rifa_id', 'Rifa', [null => 'Selecione...'] + $rifas->pluck('descricao',
        'id')->all())
        ->attrs(['class' => 'select2'])
        ->required()
        !!}
    </div>
    
</div>
<div class="row">
    <div class="col-12">
        <button type="submit" class="btn btn-success float-right mt-4">Salvar</button>
    </div>
</div>