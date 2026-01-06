@extends('layouts.app')

@section('template_title')
    Movimientocaja
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Movimientocaja') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('movimientocajas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Cajachica Id</th>
										<th>Fecha</th>
										<th>Tipo</th>
										<th>Monto</th>
										<th>Concepto</th>
										<th>Categoria</th>
										<th>Referencia</th>
										<th>Comprobante</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movimientocajas as $movimientocaja)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $movimientocaja->cajachica_id }}</td>
											<td>{{ $movimientocaja->fecha }}</td>
											<td>{{ $movimientocaja->tipo }}</td>
											<td>{{ $movimientocaja->monto }}</td>
											<td>{{ $movimientocaja->concepto }}</td>
											<td>{{ $movimientocaja->categoria }}</td>
											<td>{{ $movimientocaja->referencia }}</td>
											<td>{{ $movimientocaja->comprobante }}</td>

                                            <td>
                                                <form action="{{ route('movimientocajas.destroy',$movimientocaja->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('movimientocajas.show',$movimientocaja->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('movimientocajas.edit',$movimientocaja->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $movimientocajas->links() !!}
            </div>
        </div>
    </div>
@endsection
