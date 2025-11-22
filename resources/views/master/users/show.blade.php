@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CRUD-MASTER</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/users') }}">users</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->id }}</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">User {{ $user->id }}</h6>
                        <a href="{{ url('/users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/users/' . $user->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('users' . '/' . $user->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete User" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $user->id }}</td>
                                    </tr>
                                    <tr><td class="border px-8 py-4 font-bold"> Name </td><td class="border px-8 py-4"> {{ $user->name }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Email </td><td class="border px-8 py-4"> {{ $user->email }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Password </td><td class="border px-8 py-4"> {{ $user->password }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
