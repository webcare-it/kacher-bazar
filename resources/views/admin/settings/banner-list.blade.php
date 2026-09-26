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
                                    <h5 class="mb-1">Banner List</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('/banner/add') }}" class="btn btn-primary btn-sm">Add new</a>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Type</th>
                                           <th width="10%">Image</th>
                                           <th width="20%">Status</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                    @foreach($banners as $banner)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ ucfirst($banner->type) }}</td>
                                            <td>
                                                <img src="{{ asset('/setting/'.$banner->image) }}" height="100" width="100" alt="banner"/>
                                            </td>
                                            <td>
                                                @if($banner->status == 1)
                                                    <span>Active</span>
                                                @else
                                                    <span>Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('/banner/edit/'.$banner->id) }}" class="btn btn-sm btn-info"><i class='bx bxs-edit'></i></a>
                                                <a href="{{ url('/banner/delete/'.$banner->id) }}" onclick="return confirm('Are you sure delete this data ?')" class="btn btn-sm btn-danger"><i class='bx bxs-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
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
