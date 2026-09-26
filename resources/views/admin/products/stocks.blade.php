@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-header bg-gradient-burning">
                            <h5 class="mb-1">Stock management</h5>
                        </div>
                        <div class="card-body">

                            @if(Session::has('success'))
                                <x-alert :message="session('success')" title="Success" type="success"></x-alert>
                            @endif
                            @if(Session::has('error'))
                                <x-alert :message="session('error')" title="Error" type="error"></x-alert>
                            @endif

                            <div class="d-flex align-items-center">
                                <div>

                                </div>
                                <div class="ms-auto"></div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Name</th>
                                           <th width="10%">Price</th>
                                           <th width="10%">Stock Qty</th>
                                           <th width="10%">Status</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->regular_price }} Tk.</td>
                                            <td>
                                                <input type="number" name="qty" id="productqty-{{ $product->id }}" value="{{ $product->qty }}" onblur="productStockQtyUpdate({{ $product->id }})" />
                                            </td>
                                            <td>
                                                @if($product->qty == 0)
                                                    <span class="badge rounded-pill bg-danger">Stock out</span>
                                                @else
                                                    <span class="badge rounded-pill bg-primary">Available</span>
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

@push('script')
    <script>
        function productStockQtyUpdate(id){
            let qty = document.getElementById('productqty-' + id).value;
            axios.post('/api/product/qty/update/' + id, {
                qty: qty
            })
                .then(response => {
                    if(response.status == 200){
                        alert('Qty has been updated.')
                        location.reload()
                    }
                }).catch(error => {
                return confirm(error)
            })
        }
    </script>
@endpush
