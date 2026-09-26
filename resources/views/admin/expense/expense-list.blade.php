@extends('admin.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col">
                <div class="card radius-10 overflow-hidden bg-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Expense</p>
                                <h5 class="mb-0 text-white">
                                    {{$totalExpense}}
                                </h5>
                            </div>
                            <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="chart3"></div>
                </div>
            </div>
            {{-- <div class="col">
                <div class="card radius-10 overflow-hidden bg-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total</p>
                                <h5 class="mb-0 text-white">
                                    3
                                </h5>
                            </div>
                            <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="chart3"></div>
                </div>
            </div> --}}
            {{-- <div class="col">
                <div class="card radius-10 overflow-hidden bg-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Delivery Charge</p>
                                <h5 class="mb-0 text-white">
                                    4
                                </h5>
                            </div>
                            <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="chart3"></div>
                </div>
            </div> --}}
            {{-- <div class="col">
                <div class="card radius-10 overflow-hidden bg-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Discount</p>
                                <h5 class="mb-0 text-white">
                                    5
                                </h5>
                            </div>
                            <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="chart3"></div>
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="row">
                <div class="col-md-8">
                    <form method="GET" action="{{ url('/expenses') }}"
                        class="form-inline mb-3">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-gradient-blues">From</span>
                            <input type="date" class="form-control" name="from"
                                placeholder="From date" aria-label="Username">
                            <span class="input-group-text bg-gradient-burning">To</span>
                            <input type="date" class="form-control" name="to"
                                placeholder="To date" aria-label="Server">
                            <button type="submit" class="btn btn-sm btn-info"><i
                                    class="fa fa-search"></i> Search</button>
                            <a href="{{ url('/expenses') }}" class="btn btn-sm btn-danger"><i
                                    class="fa fa-search"></i> Clear</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 mb-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div>
                                    <h5 class="mb-1">Expense List</h5>
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
                            <a href="{{url('/add-expense')}}" class="float-end btn btn-primary">Add Expense</a>

                            {{-- <input type="button" onclick='selects()' value="Select All" class="btn btn-success float-left" style="margin-left: 10px"/>
                            <input type="button" onclick='deSelect()' value="Unselect All" class="btn btn-danger float-left"/> --}}

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        {{-- <th width="5%">Select</th> --}}
                                        <th width="5%">SL</th>
                                        <th width="15%">Titel</th>
                                        <th width="15%">Amount</th>
                                        <th width="15%">Description</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $expense->title }}</td>
                                            <td>{{ $expense->amount }}</td>
                                            <td>
                                                <textarea readonly>{{ $expense->description }}</textarea>
                                            </td>
                                            <td>
                                                <a href="{{url('/edit-expense/'.$expense->id)}}" class="badge rounded-pill bg-info">
                                                    <i class="bx bx-edit-alt" style="font-size: 20px; color: rgb(244, 247, 248);"></i>
                                                </a>
                                                {{-- <a href="" onclick="return confirm('Are you sure?')" class="badge rounded-pill bg-danger">
                                                    <i class="bx bx-trash-alt" style="font-size: 20px; color: rgb(243, 237, 237);"></i>
                                                </a> --}}
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