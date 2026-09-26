@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">

                            @if(Session::has('success'))
                                <x-alert :message="session('success')" title="Success" type="success"></x-alert>
                            @endif
                            @if(Session::has('error'))
                                <x-alert :message="session('error')" title="Error" type="error"></x-alert>
                            @endif

                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Settings</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('/slider/create') }}" class="btn btn-primary btn-sm">Add new</a>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Name</th>
                                           <th width="20%">Status</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @if(!empty($sliders))
                                            @foreach ($sliders as $slider)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        <img src="{{ asset('/setting/'.$slider->image) }}" height="100" width="300" />
                                                    </td>
                                                    <td class="">
                                                        @if($slider->status == 1)
                                                            <span class="badge bg-light-success text-success w-100">Active</span>
                                                        @else
                                                            <span class="badge bg-light-danger text-success w-100">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ url('/slider/edit/'.$slider->id) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
                                                        <a href="{{ url('/slider/delete/'.$slider->id) }}" class="ms-4 text-danger bg-light-danger border-0"><i class='bx bxs-trash-alt' ></i></a>
                                                    </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                       @endif
                                   </tbody>
                               </table>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
