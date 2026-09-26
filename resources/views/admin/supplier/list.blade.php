@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div>
                                        <h5 class="mb-1">Supplier</h5>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form action="{{ url('/supplier/list') }}" method="GET">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" class="form-control" placeholder="Search...">
                                            <button type="submit" class="input-group-text bg-primary text-white">Search</button>
                                            <a href="{{ url('/supplier/list') }}" class="input-group-text bg-danger text-white">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="15%">Name</th>
                                           <th width="15%">Shop Name</th>
                                           <th width="15%">Phone</th>
                                           <th width="20%">Email</th>
                                           <th width="20%">Address</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $supplier->full_name?? 'No name found' }}</td>
                                            <td>{{ $supplier->shop_name?? 'No name found' }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td>
                                                <a href="{{ url('/supplier/delete/' .$supplier->id) }}" onclick="return confirm('Are you sure parmanent delete this information.')" class="btn btn-sm btn-danger">Delete</a>
                                                @if($supplier->is_approved == 1)
                                                <a href="{{ url('/supplier/active/' .$supplier->id) }}" class="btn btn-sm btn-success">Active</a>
                                                @else
                                                <a href="{{ url('/supplier/inactive/' .$supplier->id) }}" class="btn btn-sm btn-warning">Inactive</a>
                                                @endif
                                            </td>
                                        </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                               {{ $suppliers->links() }}
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
