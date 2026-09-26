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
                                    <h5 class="mb-1">Blogs</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('/blog/create') }}" class="btn btn-primary btn-sm">Add new</a>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Title</th>
                                           <th width="10%">Image</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @if(!empty($data))
                                            @foreach ($data as $blog)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $blog->title }}</td>
                                                    <td>
                                                        <img src="{{ asset('/blogs/'.$blog->image) }}" height="80" width="100" />
                                                    </td>
                                                    <td>
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ url('/blog/edit/'. $blog->id) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-edit'></i></a>
                                                        <a href="{{ url('/blog/delete/'. $blog->id) }}" onclick="return confirm('Are you sure delete this information.')" class="ms-4 text-danger bg-light-primary border-0"><i class='bx bxs-trash-alt'></i></a>
                                                    </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                       @endif
                                   </tbody>
                               </table>
                               {{ $data->links() }}
                           </div>
                           @elseif ($page == 'create')
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-1">Blog create</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{ url('/blog/list') }}" class="btn btn-primary btn-sm">Blog list</a>
                                    </div>
                                </div>
                                <form action="{{ url('/blog/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="title" class="form-control" placeholder="Blog title">
                                        <span style="color: red"> {{ $errors->has('title') ? $errors->first('title') : ' ' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="ckeditor form-control" name="description" id="" placeholder="Blog description"></textarea>
                                        <span style="color: red"> {{ $errors->has('title') ? $errors->first('title') : ' ' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="image" class="form-control" />
                                        <span style="color: red"> {{ $errors->has('image') ? $errors->first('image') : ' ' }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
                                </form>
                           @elseif($page == 'edit')
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Blog update</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('/blog/list') }}" class="btn btn-primary btn-sm">Blog list</a>
                                </div>
                            </div>
                            <form action="{{ url('/blog/update/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="title" class="form-control" value="{{ $data->title }}" placeholder="Blog title">
                                    <span style="color: red"> {{ $errors->has('title') ? $errors->first('title') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="ckeditor form-control" name="description" id="" placeholder="Blog description">{{ $data->description }}</textarea>
                                    <span style="color: red"> {{ $errors->has('title') ? $errors->first('title') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" /><br/>
                                    <img src="{{ asset('/blogs/'.$data->image) }}" height="80" width="80" />
                                    <span style="color: red"> {{ $errors->has('image') ? $errors->first('image') : ' ' }}</span>
                                </div>
                                <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
                            </form>
                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
