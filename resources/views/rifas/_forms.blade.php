<div class="row">
    <div class="col-md-12">
        {!!Form::text('descricao', 'Descrição')
        ->attrs(['class' => 'form-control'])
        ->required()
        !!}
    </div>

    <div class="col-md-12">
        {!!Form::textarea('observacao', 'Observação')
        ->attrs(['class' => 'form-control', 'rows' => 4])
        !!}
    </div>

    <div class="col-md-2">
        {!!Form::date('data_sorteio', 'Data do sorteio')
        ->attrs(['class' => 'form-control'])
        ->required()
        !!}
    </div>
    <div class="col-md-2">
        {!!Form::tel('maximo_de_vendas', 'Máximo de vendas')
        ->attrs(['class' => 'form-control', 'data-mask' => '000'])
        ->required()
        !!}
    </div>

    <div class="col-md-2">
        {!!Form::tel('valor', 'Valor')
        ->attrs(['class' => 'form-control money'])
        ->required()
        !!}
    </div>

    <div class="col-md-2">
        {!!Form::select('status', 'Status', ['1' => 'Ativo', '0' => 'Desativado'])
        ->attrs(['class' => 'form-control'])
        ->required()
        !!}
    </div>

    <div class="col-md-3">
        {!!Form::file('file', 'Imagem')
        ->attrs(['accept' => 'image/*'])
        ->required(isset($item) ? false : true)
        !!}
        @isset($item)
        <img class="round" src="/img_rifas/{{ $item->imagem }}">
        @endif
    </div>
</div>
<div class="row">
    <div class="col-12">
        <button type="submit" class="btn btn-success float-right mt-4">Salvar</button>
    </div>
</div>