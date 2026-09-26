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
                                    <h5 class="mb-1">User List</h5>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            {{-- <div class="col-md-4">
                                <form action="{{ url('/order/pending') }}" method="get">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search...">
                                        <button type="submit" class="input-group-text bg-primary text-white">Search</button>
                                        <a href="{{ url('/order/pending') }}" class="input-group-text bg-danger text-white">Clear</a>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                        <form action="{{ url('/order/update') }}" method="post">
                            @csrf

                            {{-- <button type="submit" name="action" value="cancel" class="btn btn-danger float-right" style="cursor: pointer">Cancel</button>
                            <button type="submit" name="action" value="hold" class="btn btn-warning float-right mr-2" style="cursor: pointer">Hold</button>
                            <button type="submit" name="action" value="complete" class="btn btn-info float-right mr-2" style="cursor: pointer">Complete</button>
                            <button type="submit" name="action" value="delete" class="btn btn-danger float-right" style="cursor: pointer">Delete</button> --}}
                            <a href="{{url('/add-user')}}" class="float-end btn btn-primary">Add User</a>

                            {{-- <input type="button" onclick='selects()' value="Select All" class="btn btn-success float-left" style="margin-left: 10px"/>
                            <input type="button" onclick='deSelect()' value="Unselect All" class="btn btn-danger float-left"/> --}}

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        {{-- <th width="5%">Select</th> --}}
                                        <th width="5%">SL</th>
                                        <th width="15%">Name</th>
                                        <th width="15%">Email</th>
                                        <th width="15%">Order Limit</th>
                                        <th width="15%">Status</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            {{-- <td>
                                                @if($order->status == 0)
                                                    <input type="checkbox" name="id[]" id="id{{ $order->id }}" value="{{ $order->id }}" />
                                                @endif
                                            </td> --}}
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>
                                                <a href="{{url('/user/details/'.$user->id)}}">
                                                    {{ $user->name?? 'No name found' }}
                                                </a>
                                            </td>
                                            <td>{{ $user->email?? 'No Email found' }}</td>
                                            <td>{{ $user->order_limit?? 'No Limit found' }}+(1)</td>
                                            <td>
                                                @if ($user->is_active==1)
                                                    <span class="badge rounded-pill bg-primary">Active</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{url('/edit-user/'.$user->id)}}" class="badge rounded-pill bg-info">
                                                    <i class="bx bx-edit-alt" style="font-size: 20px; color: rgb(244, 247, 248);"></i>
                                                </a>
                                                @if($user->is_active == 1)
                                                    <a href="{{url('/inactivate-user/'.$user->id)}}" class="badge rounded-pill bg-success">
                                                        <i class="bx bx-up-arrow-alt" style="font-size: 20px; color: rgb(239, 241, 241);"></i>
                                                    </a>
                                                @else
                                                    <a href="{{url('/activate-user/'.$user->id)}}" class="badge rounded-pill bg-warning">
                                                        <i class="bx bx-down-arrow-alt" style="font-size: 20px; color: rgb(230, 59, 59);"></i>
                                                    </a>
                                                @endif
                                                <a href="{{url('/delete-user/'.$user->id)}}" onclick="return confirm('Are you sure?')" class="badge rounded-pill bg-danger">
                                                    <i class="bx bx-trash-alt" style="font-size: 20px; color: rgb(243, 237, 237);"></i>
                                                </a>
                                            </td>
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
            //console.log(selec);
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
