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
                                    <h5 class="mb-1">Categories</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">Add new</a>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Image</th>
                                           <th width="10%">Name</th>
                                           <th width="10%">Status</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @if(!empty($categories))
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        <img src="{{ asset('/category/'.$category->image) }}" style="height: 50px; width: 50px; border-radius: 50%" alt="category image" />
                                                    </td>
                                                    <td>{{ $category->name }}</td>
                                                    <td class="">
                                                        @if($category->status == 1)
                                                            <span class="badge bg-light-success text-success w-100">Active</span>
                                                        @else
                                                            <span class="badge bg-light-danger text-success w-100">Inactive</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                    <div class="d-flex order-actions">
                                                        <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm text-danger bg-light-danger border-0" style="margin-top: 2px;">
                                                                <i class='bx bxs-trash' style="font-size: 16px; margin-left: 6px;"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('categories.edit', $category->id) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit' ></i></a>
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
