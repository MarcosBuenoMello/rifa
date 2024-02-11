<div class="row">
    <div class="col-md-12">
        {!!Form::text('descricao', 'Descrição')
        ->attrs(['class' => 'form-control'])
        ->required()
        !!}
    </div>
    <div class="col-md-4">
        {!!Form::select('rifa_id', 'Rifa', ['' => 'Selecione a rifa'] + $rifas->pluck('descricao', 'id')->all())
        ->attrs(['class' => 'form-control select2'])
        ->required()
        !!}
    </div>

    <div class="col-md-3">
        {!!Form::file('file', 'Imagem')
        ->attrs(['accept' => 'image/*'])
        ->required(isset($item) ? false : true)
        !!}
        @isset($item)
        <img class="round" src="/img_premio_rifas/{{ $item->imagem }}">
        @endif
    </div>
</div>
<div class="row">
    <div class="col-12">
        <button type="submit" class="btn btn-success float-right mt-4">Salvar</button>
    </div>
</div>