@extends('admin.master')

@push('style')

@endpush

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-header bg-gradient-burning">
                            <a href="{{ url('/expenses') }}" class="btn btn-sm btn-primary float-end" style="margin-top: -25px;">Expense List</a>
                        </div>
                        <div class="card-body">
                                <form action="{{ url('/update-expense/'.$expense->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Expense Type</label>
                                    <input type="text" name="title" class="form-control" value="{{$expense->title}}" placeholder="Enter Expense Type..." required/>
                                    <span style="color: red"> {{ $errors->has('title') ? $errors->first('title') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control" value="{{$expense->amount}}" placeholder="Enter amount" required/>
                                    <span style="color: red"> {{ $errors->has('amount') ? $errors->first('amount') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="6" placeholder="Enter Description" required>{{$expense->description}}</textarea>
                                    <span style="color: red"> {{ $errors->has('description') ? $errors->first('description') : ' ' }}</span>
                                </div>
                                <button type="submit" class="btn btn-success mt-2 float-right">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection