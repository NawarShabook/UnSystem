@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">All Student</h1>
                {{-- <a class="btn btn-success" href="{{route('student.index')}}">All Students</a>
                <a class="btn btn-warning" href="{{route('student.create')}}">Add Students</a> --}}
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
    <div class="row mb-2 ">
        <div class="col-4 " title="serch by name">
            <input type="text" class="form-control text-center" id="name" onkeyup="filterSrch(3,'name')" placeholder="بحث عن طريق الاسم">
        </div>
        
        <div class="col-4 px-5" >
            <div class="dropdown hierarchy-select " id="example" >
                            
                <button type="button" class="btn btn-secondary dropdown-toggle" id="example-two-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                
                <div class="dropdown-menu" aria-labelledby="example-two-button">
                    <div class="hs-searchbox">
                        <input type="text" id="section" class="form-control" autocomplete="off" onkeyup="filterSrch(5,'section')" placeholder="بحث عن طريق القسم">
                    </div>
                    <div class="hs-menu-inner">
                        @php
                        $coleges= array("en"=>"الهندسة", "mng"=>"الإدارة والاقتصاد", "ed"=>"التربية", "law"=>"الشريعة والقانون", "hlth"=>"العلوم الصحية");
                            $i=1;
                        @endphp
                        <a class="dropdown-item" data-value="1" href="">بحث عن طريق القسم</a>
                        @foreach ($coleges as $colege)
                        <a class="dropdown-item" calss="$colege" data-value="{{++$i}}" value="{{$colege}}" onclick="filterSrch(5,'{{$colege}}')" >
                            {{$colege}}
            
                        </a>
                        @endforeach

                    </div>
                </div>
                <input class="d-none" name="example_two" readonly="readonly" aria-hidden="true" type="text"/>
            </div>
            {{-- <input type="text" class="form-control text-center" id="section" > --}}
        </div>
        <div class="col-4">
            <input type="text" class="form-control text-center" id="room" onkeyup="filterSrch(7,'room')" placeholder="بحث عن طريق رقم الغرفة">
        </div>
    </div>

    <div class="row">

        @if (count($students) > 0)
            <div class="col">
                <table class="table table-bordered" id='std'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>id</th>
                            <th>معرف المستخدم</th>
                            <th>الاسم واللقب</th>
                            <th>اسم الأب</th>
                            <th>الكلية والقسم</th>
                            <th>السنة الدراسية</th>
                            <th>رقم الغرفة</th>
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
                            <td>{{$i++}}</td>        
                            <td >{{$student->id}}</td>
                            <td >{{$student->user->id}}</td>
                            <td>{{$student->firstName.' '.$student->lastName}}</td>
                            <td>{{$student->fatherName}}</td>
                            <td>{{$student->college.'/'.$student->section}}</td>
                            <td>{{$student->level}}</td>
                            <td>{{$student->room}}</td>
                           <td>{{$student->created_at->format('d/m/Y')}}<br>{{$student->created_at->format('H:i')}}</td>
                            <td>
                                <a title="show" href="{{route('student.show',$student->id)}}" class="btn btn-info btn-sm">عرض</a> &nbsp;&nbsp;
                               
                                <form action="{{route('student.destroy',$student->id)}}" method="POST" style="display: inline;" onsubmit="return window.confirm('هل أنت متأكد من الحذف')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" title="delete" class="btn btn-danger btn-sm" value="حذف">
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
