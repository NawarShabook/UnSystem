@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h2 class="display-4">كل طلبات التسجيل</h2>
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
                                <th>user id</th>
                                <th>الاسم واللقب</th>
                                <th>اسم الأب</th>
                                <th>الكلية والقسم</th>
                                <th>السنة الدراسية</th>
                                <th>تاريخ الطلب</th>
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
                            <td >{{$student->user_id}}</td>
                            
                            <td>{{$student->firstName.' '.$student->lastName}}</td>
                            <td>{{$student->fatherName}}</td>
                            <td>{{$student->college.'/'.$student->section}}</td>
                            <td>{{$student->level}}</td>
                            <td>{{$student->created_at->diffForHumans()}}</td>
                            <td>
                                <a title="show" href="{{route('studentReq.show',$student->id)}}"><i class="fa-solid fa-2x fa-eye"></i></a> &nbsp;&nbsp;
                               
                                <form action="{{route('studentReq.destroy',$student->id)}}" method="POST" style="display: inline;">
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
                No Students Request to display
            </div>
        @endif

    </div>
</div>

@endsection
