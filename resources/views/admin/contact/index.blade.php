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
                                        <h5 class="mb-1">Contact</h5>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form action="{{ url('/contacts') }}" method="GET">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" class="form-control" placeholder="Search...">
                                            <button type="submit" class="input-group-text bg-primary text-white">Search</button>
                                            <a href="{{ url('/contacts') }}" class="input-group-text bg-danger text-white">Clear</a>
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
                                           <th width="15%">Phone</th>
                                           <th width="20%">Email</th>
                                           <th width="20%">Subject</th>
                                           <th width="20%">Message</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($contacts as $contact)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $contact->name?? 'No name found' }}</td>
                                            <td>{{ $contact->phone }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->subject }}</td>
                                            <td>{{ substr($contact->message, 0, 30) }}</td>
                                            <td>
                                                <a href="{{ url('/contact/delete/' .$contact->id) }}" onclick="return confirm('Are you sure parmanent delete this information.')" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                               {{ $contacts->links() }}
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
