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
                                    <h5 class="mb-1">Customer orders Delivered</h5>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <form action="{{ url('/order/delivered/list') }}" method="get">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search...">
                                        <button type="submit" class="input-group-text bg-primary text-white">Search</button>
                                        <a href="{{ url('/order/delivered/list') }}" class="input-group-text bg-danger text-white">Clear</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <form action="{{ url('/order/update') }}" method="post">
                            @csrf
                            {{-- <button type="submit" name="action" value="complete" class="btn btn-primary float-right mr-2" style="cursor: pointer">Complete</button> --}}

                            <input type="button" onclick='selects()' value="Select All" class="btn btn-success float-left"/>
                            <input type="button" onclick='deSelect()' value="Unselect All" class="btn btn-danger float-left" style="margin-left: 10px"/>

                            <button type="submit" name="action" value="delete" class="btn btn-danger float-right" style="cursor: pointer">Delete</button>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">Select</th>
                                           <th width="5%">SL</th>
                                           <th width="15%">Order ID</th>
                                           <th width="15%">Customer Name</th>
                                           <th width="20%">Qty</th>
                                           <th width="20%">Total Price</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                   @foreach ($returnDeliveredList as $key => $order)
                                       <tr>
                                           <td>
                                               @if($order->order_status != null)
                                                   <input type="checkbox" name="id[]" id="id{{ $order->id }}" value="{{ $order->id }}" />
                                               @endif
                                           </td>
                                           <td>{{ $loop->index+1 }}</td>
                                           <td>
                                               <a href="{{ url('/order/view/' .$order->id) }}">{{ $order->orderId ?? 'No order id found' }}</a>
                                           </td>
                                           <td>{{ $order->name?? 'No name found' }}</td>
                                           <td>{{ $order->qty }}</td>
                                           <td>{{ $order->price }} Tk.</td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                               </table>
                           </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        function selects(){
            var selec=document.getElementsByName('id[]');
            console.log(selec);
            for(var i=0; i<selec.length; i++){
                if(selec[i].type == 'checkbox')
                    selec[i].checked=true;
            }
        }
        function deSelect(){
            var selec=document.getElementsByName('id[]');
            for(var i=0; i<selec.length; i++){
                if(selec[i].type == 'checkbox')
                    selec[i].checked=false;

            }
        }
    </script>
@endpush
