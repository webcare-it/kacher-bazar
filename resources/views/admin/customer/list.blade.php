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
                                        <h5 class="mb-1">Customer</h5>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form action="{{ url('/customer/list') }}" method="GET">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" class="form-control" placeholder="Search...">
                                            <button type="submit" class="input-group-text bg-primary text-white">Search</button>
                                            <a href="{{ url('/customer/list') }}" class="input-group-text bg-danger text-white">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="15%">Avatar</th>
                                           <th width="15%">Name</th>
                                           <th width="15%">Phone</th>
                                           <th width="20%">Email</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>
                                                <img src="{{ asset('/avatar/'.$customer->avatar) }}" height="60" width="60" style="border-radius: 100%" />
                                            </td>
                                            <td>{{ $customer->full_name?? 'No name found' }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>
                                                <a href="{{ url('/customer/delete/' .$customer->id) }}" onclick="return confirm('Are you sure parmanent delete this information.')" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                               {{ $customers->links() }}
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
