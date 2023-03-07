@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">All Student</h1>
                <a class="btn btn-success" href="{{route('student.index')}}">All Students</a>
                <a class="btn btn-warning" href="{{route('student.create')}}">Add Students</a>
                @if (Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @elseif(Session::get('errors'))
                <div class="alert alert-danger" role="alert">
                    {{Session::get('errors')}}
                </div>
                @endif
            </div>
        </div>

    </div>
    <div class="row">

        @if (count($students) > 0)
            <div class="col">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <tr>
                                <th>id</th>
                                <th>الاسم واللقب</th>
                                <th>اسم الأب</th>
                                <th>الكلية والقسم</th>
                                <th>السنة الدراسية</th>
                                <th>تاريخ الإضافة</th>
                                <th>Actions</th>
                                </tr>
                        </tr>
                    </thead>
                    @php
                        $i=1;
                    @endphp
                    <tbody>
                        @foreach ($students as $student)
                        <tr class="table-primary" >
                                    
                            <td >{{$student->id}}</td>
                            <td>{{$student->firstName.' '.$student->lastName}}</td>
                            <td>{{$student->fatherName}}</td>
                            <td>{{$student->college.'/'.$student->section}}</td>
                            <td>{{$student->level}}</td>
                            <td>{{$student->created_at->diffForHumans()}}</td>
                            <td>
                                <a title="show" href="{{route('student.show',$student->id)}}"><i class="fa-solid fa-2x fa-eye"></i></a> &nbsp;&nbsp;
                               
                                <form action="{{route('student.destroy',$student->id)}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="delete" class="text-danger" style="border:none; background-color: transparent" ><i class="fa-solid fa-2x fa-trash"></i></i>
                                </form>
                            </td>
                            
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                No Students to display
            </div>
        @endif

    </div>
</div>

@endsection
