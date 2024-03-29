@extends('layouts.app')

@section('content')
    

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">بيانات طلب التسجيل</h1>
                @if (Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @elseif($errors->all())
                <div class="alert alert-danger" role="alert">
                    <ul class="text-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    <hr>
    <div>
    <form method="POST" action="{{route('student.store')}}" enctype="multipart/form-data" >
        @csrf
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5 ">
                <div class="image-upload">
                    <img class=" rounded-circle mt-5" id='stdImage' width="150px" alt="Upload Image" src="{{$student->image}}">
                    <span class="text-success d-none" id="checked-badge" ><i class="fa-solid fa-check-double"></i></span>

                    <input id="image-input" type="file" name="image" accept="image/*" onchange="checkImageUpload()">
                </div>
                
                <span class="font-weight-bold">{{$student->firstName.' '.$student->lastName}}</span>
                <span class="text-black-50">{{$student->email}}</span>
                <span> </span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-left">id:{{$student->id}}</h4>
                    <h4 class="text-right">بيانات الطالب </h4> 
                   
                </div>
                <div class='border p-2'>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">الاسم الأول</label><input  type="text" name="firstName" class="form-control " placeholder="الاسم الأول" value={{$student->firstName}}></div>
                        <div class="col-md-6"><label class="labels">الاسم الأخير</label><input  required type="text" name="lastName" class="form-control " value={{$student->lastName}} placeholder="الاسم الأخير"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">اسم الأب</label><input  required type="text"  name="fatherName" class="form-control " placeholder="اسم الأب" value={{$student->fatherName}}></div>
                        <div class="col-md-6"><label class="labels">اسم الأم</label><input  required type="text" name="motherName" class="form-control " placeholder="اسم الأم" value={{$student->motherName}}></div>
                        
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">تاريخ الولادة</label><input  required type="date" name="birthDay" class="form-control " placeholder="تاريخ الميلاد" value={{$student->birthDay}}></div>
                        <div class="col-md-6"><label class="labels">المدينة</label><input  required type="text" name="city" class="form-control " placeholder="المدينة" value={{$student->city}}></div>

                    </div>    

                    <div class="row mt-2">
                         @isAdmin
                         <div class="col-md-6">
                            <label class="labels" for="form3Example1m1" >رقم الغرفة</label>
                                <input  required type="number" id="form3Example1m1" name="room" value='0' class="form-control " />
                         </div>
                         @endisAdmin
                         <div class="col-md-6">
                            <label class="labels" for="form3Example1n1">رقم الهاتف</label>

                             <input  required type="tel" name="phoneNumber" id="form3Example1n1" placeholder="رقم الهاتف" value={{$student->phoneNumber}} class="form-control " />
                         </div>
                     </div>

                     <div class='row m-2'>
                        <input type="email" placeholder="email address"  name='email' class="form-control" value="{{$student->email}}" />
                        
                    </div>
                    
                    <div class="row mt-2 d-md-flex justify-content-start align-items-center mb-2 py-2 bg">
                        <div class="col-md-2 mb-0 me-4"><label class="labels fs-6">الجنس:</label></div>
                        
                        <div class="col-md-2">
                            <input  required class="form-check-input" type="radio" name="gender" id="femaleGender" value="أنثى" />
                            <label class="form-check-label" for="femaleGender">أنثى</label>
                        </div>

                        <div class="col-md-2">
                            <input  class="form-check-input" type="radio" name="gender" id="maleGender" value="ذكر" />
                            <label class="form-check-label" for="maleGender">ذكر</label>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4 mb-4">
                            <label class="labels">الكلية</label>        
                            <select  id='college' class="select btn btn-primary" name="college" required onchange="test_college('college','college')" >                                    
                                <option class="college" value="">الكلية</option>
                                <option class="college" value="en">الهندسة</option>
                                <option class="college" value="mng">الإدارة والاقتصاد</option>
                                <option class="college" value="ed">التربية</option>
                                <option class="college" value="law">الشريعة والقانون</option>
                                <option class="college" value="hlth">العلوم الصحية</option>
                            </select>

                        </div>
                                
                        <div class="col-md-4 mb-4">
                            <label class="labels">القسم</label>
                            <select  class="select btn btn-secondary" id='section' name='section' required>
                                <option class='dropdown-item section' value="">القسم</option>
                                <option class='dropdown-item en'  hidden value="المعلوماتية">المعلوماتية</option>
                                <option class='dropdown-item en' hidden value="المدنية">المدنية</option>
                                <option class='dropdown-item en' hidden value="الميكاترونيكس">الميكاترونيكس</option>
                                <option class='dropdown-item mng' hidden value="الإدارة">الإدارة</option>
                                <option class='dropdown-item mng' hidden value="المحاسبة">المحاسبة</option>
                                <option class='dropdown-item ed' hidden value="معلم-صف">معلم صف</option>
                                <option class='dropdown-item ed' hidden value="الإرشاد-النفسي">الإرشاد النفسي</option>
                                <option class='dropdown-item law' hidden value="الشريعة">الشريعة</option>
                                <option class='dropdown-item law' hidden value="القانون">القانون</option>
                                <option class='dropdown-item hlth' hidden value="التمريض">التمريض</option>
                                <option class='dropdown-item hlth' hidden value="التخدير">التخدير</option>
                                <option class='dropdown-item hlth' hidden value="العلاج-الفيزيائي">العلاج الفيزيائي</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="labels">السنة الدراسية</label>
                            <select  class="select btn btn-warning" required id='level' name='level'>
                                <option value="">السنة الدراسية</option>
                                <option value="الأولى">الأولى</option>
                                <option value="الثانية">الثانية</option>
                                <option value="الثالثة">الثالثة</option>
                                <option value="الرابعة">الرابعة</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center pt-3 pb-3 border mt-4">
                        <input hidden type="text" name="oldReqId" value="{{$student->id}}">
                        <input type="reset" class="btn btn-warning ms-2" />
                        <input type="submit" class="btn btn-success ms-2" value="قبول الطلب" />
                    <div>
                        <form action=""></form>
                        <form action="{{route('studentReq.destroy',$student->id)}}" id="df" method="POST" style="display: inline;" onsubmit="return window.confirm('هل أنت متأكد من الحذف')">
                            @csrf
                            @method('DELETE')
                            <button id="delete"  title="delete" class="btn btn-danger ms-2">حذف الطلب </button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center experience"><span>Edit Experience</span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span></div><br>
                    <div class="col-md-12"><label class="labels">Experience in Designing</label><input type="text" class="form-control " placeholder="experience" value=""></div> <br>
                    <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control " placeholder="additional details" value=""></div>
                </div>
            </div>
        </div>
    </fieldset>
</div>
</div>

</form>
</div>
<script>
    
    let gender = document.querySelector('input[value={{$student->gender}}]');
    gender.setAttribute("checked","");

    document.querySelector('option[value={{$student->college}}]').setAttribute("selected","");
    document.querySelector('option[value={{$student->section}}]').setAttribute("selected","");
    document.querySelector('option[value={{$student->level}}]').setAttribute("selected","");
   
    
</script>
@endsection