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
                                    <h5 class="mb-1">Products</h5>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Name</th>
                                           <th width="10%">Whole Sale Price</th>
                                           <th width="10%">Status</th>
                                           <th width="10%" class="text-center">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>
                                                <img src="{{$imagePath.$product['image']}}" height="50" width="50" />
                                                {{ $product['name']}}
                                            </td>
                                            <td>{{ $product['wholesale_price'] }} Tk.</td>
                                            <td>
                                                @if(in_array($product['id'], $existingProductIds ?? []))
                                                    <span class="badge rounded-pill bg-success">Added</span>
                                                @else
                                                    <span class="badge rounded-pill bg-warning">Not Added</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array($product['id'], $existingProductIds ?? []))
                                                    <span class="badge rounded-pill bg-secondary">Already Added</span>
                                                @else
                                                    <a href="{{url('add-droploo-product/'.$product['id'])}}" class="badge rounded-pill bg-info">Add</a>
                                                @endif
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
