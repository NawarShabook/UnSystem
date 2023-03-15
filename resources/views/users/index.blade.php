@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">All Users</h1>
                <a class="btn btn-success" href="{{route('users.create')}}">Create User</a>
                @if (Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @endif
            </div>
        </div>

    </div>
    <div class="row">

        @if (count($users) > 0)
            <div class="col">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    @php
                        $i=1;
                    @endphp
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if ($user->role==1)
                                    {{"مدير"}}
                                @else
                                    {{"طالب"}}
                                @endif
                            </td>
                            <td>
                                <form action="{{route('users.destroy',$user->id)}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="delete" class="text-danger" style="border:none; background-color: transparent" ><i class="fa-solid fa-2x fa-trash"></i>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                No users to display
            </div>
        @endif


    </div>
</div>

@endsection
