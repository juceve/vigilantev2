@extends('layouts.app')

@section('template_title')
    Cajachica
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Cajachica') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('cajachicas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Empleado Id</th>
										<th>Gestion</th>
										<th>Fecha Apertura</th>
										<th>Fecha Cierre</th>
										<th>Estado</th>
										<th>Observacion</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cajachicas as $cajachica)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $cajachica->empleado_id }}</td>
											<td>{{ $cajachica->gestion }}</td>
											<td>{{ $cajachica->fecha_apertura }}</td>
											<td>{{ $cajachica->fecha_cierre }}</td>
											<td>{{ $cajachica->estado }}</td>
											<td>{{ $cajachica->observacion }}</td>

                                            <td>
                                                <form action="{{ route('cajachicas.destroy',$cajachica->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('cajachicas.show',$cajachica->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('cajachicas.edit',$cajachica->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $cajachicas->links() !!}
            </div>
        </div>
    </div>
@endsection
