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
                                    <h5 class="mb-1">Brands</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm">Add new</a>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Name</th>
                                           <th width="10%">Category Name</th>
                                           <th width="10%">Subcategory Name</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @if(!empty($brands))
                                            @foreach ($brands as $brand)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $brand->name }}</td>
                                                    <td>{{ $brand->category->name ?? '' }}</td>
                                                    <td>{{ $brand->subcategory->name ?? '' }}</td>
                                                    <td>
                                                    <div class="d-flex order-actions">
                                                        <form action="{{ route('brands.destroy', $brand->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm text-danger bg-light-danger border-0" style="margin-top: 2px;">
                                                                <i class='bx bxs-trash' style="font-size: 16px; margin-left: 6px;"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('brands.edit', $brand->id) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
                                                    </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                       @endif
                                   </tbody>
                               </table>
                               {{ $brands->links() }}
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
