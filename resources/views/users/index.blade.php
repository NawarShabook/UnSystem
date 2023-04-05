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
                            <th scope="col">id</th>
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
                            <td>{{$user->id}}</td>
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
                                <form action="{{route('users.destroy',$user->id)}}" method="POST" style="display: inline;" onsubmit="return window.confirm('هل أنت متأكد من الحذف')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" title="delete" class="btn btn-danger btn-sm"  value="حذف" >
                                </form>

                                <a href="{{route('users.edit', $user->id)}}" title="edit" class="btn btn-warning btn-sm mx-4">تعديل</a>
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
