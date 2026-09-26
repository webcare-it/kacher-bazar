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

                            @if($page == 'index')
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-1">Page List</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{ url('/page/create') }}" class="btn btn-primary btn-sm">Add new</a>
                                    </div>
                                </div>

                               <div class="table-responsive mt-3">
                                   <table class="table align-middle mb-0">
                                       <thead class="table-light">
                                           <tr>
                                               <th width="5%">SL</th>
                                               <th width="10%">Name</th>
                                               <th width="20%">Status</th>
                                               <th width="10%">Actions</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($pages as $page)
                                               <tr>
                                                   <td>{{ $loop->index + 1 }}</td>
                                                   <td>{{ $page->name }}</td>
                                                   <td class="">
                                                       @if($page->status == 1)
                                                           <span class="badge bg-light-success text-success w-100">Active</span>
                                                       @else
                                                           <span class="badge bg-light-danger text-success w-100">Inactive</span>
                                                       @endif
                                                   </td>
                                                   <td>
                                                       <div class="d-flex order-actions">
                                                           <a href="{{ url('/page/edit/'.$page->id) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit'></i></a>
                                                           @if($page->status == 0)
                                                            <a href="{{ url('/page/active/'.$page->id) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-like'></i></a>
                                                           @else
                                                            <a href="{{ url('/page/inactive/'.$page->id) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-dislike'></i></a>
                                                           @endif
                                                           <a href="{{ url('/page/delete/'.$page->id) }}" onclick="return confirm('Are you sure delete this page ?')" class="ms-4 text-danger bg-light-danger border-0"><i class='bx bxs-trash-alt' ></i></a>
                                                       </div>
                                                   </td>
                                               </tr>
                                           @endforeach
                                       </tbody>
                                   </table>
                               </div>
                           @endif
                            @if($page == 'create')
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-1">Page Create</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{ url('/page/list') }}" class="btn btn-primary btn-sm">Manage Page</a>
                                    </div>
                                </div>
                                <form action="{{ url('/page/store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Page name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Add new page..." />
                                        <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option selected disabled>Select a page</option>
                                            <option value="1" {{ old('status') }}>Active</option>
                                            <option value="0" {{ old('status') }}>Inactive</option>
                                        </select>
                                        <span style="color: red"> {{ $errors->has('status') ? $errors->first('status') : ' ' }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                </form>
                            @endif

                            @if($page == 'edit')
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-1">Page Create</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{ url('/page/list') }}" class="btn btn-primary btn-sm">Manage Page</a>
                                    </div>
                                </div>
                                <form action="{{ url('/page/update/'.$editPage->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Page name</label>
                                        <input type="text" class="form-control" value="{{ $editPage->name }}" name="name" id="name" placeholder="Add new page..." />
                                        <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option selected disabled>Select a page</option>
                                            <option value="1" {{ $editPage->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $editPage->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <span style="color: red"> {{ $errors->has('status') ? $errors->first('status') : ' ' }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
