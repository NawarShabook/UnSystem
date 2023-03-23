<?php

namespace App\Http\Controllers;

use App\Models\StudentReq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReqController extends Controller
{
    /**
     * Display a listing of the resource.
    */

    public function index()
    {
        $students=StudentReq::all();
        return view('studentReq.index',['students'=>$students]);
    }

    /**
     * Show the form for creating a new resource.
    */

    public function create()
    {
        $user=Auth::user();

        if($user->student)
        {
            return redirect()->route('home')->withErrors("اسمك مسجل مسبقا في النظام");
            
        }
        elseif($user->studentReq)
        {
            return redirect()->route('home')->withErrors("لا يمكنك إرسال أكثر من طلب تسجيل، الرجاء الانتظار حتى يتم معالجة طلبك");
        }
        else
        {
            $user_id = $user->id;
            return view('studentReq.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $colege= array("en"=>"الهندسة", "mng"=>"الإدارة والاقتصاد", "ed"=>"التربية", "law"=>"الشريعة والقانون", "hlth"=>"العلوم الصحية");
        $validated = $request->validate([
            "firstName"=>"required",
            "lastName"=>"required",
            "fatherName"=>"required",
            "motherName"=>"required",
            "birthDay"=>"required|date",
            "gender"=>"required",
            "college"=>"required",
            "section"=>"required",
            "level"=>"required|in:الأولى,الثانية,الثالثة,الرابعة",
            "city"=>"required",
            "phoneNumber"=>"required",
            "email"=>"required|email",
            "image"=>"image",
        ]);

        $user=Auth::user();
        if($user->studentReq==null)
        {
            $user_id = $user->id;
        }
        else
        {
            return redirect()->back()->withErrors("you cannot send more one Request");
        }
        //mass assignment
        $student=StudentReq::create([
            "firstName"=>$request->firstName,
            "lastName"=>$request->lastName,
            "fatherName"=>$request->fatherName,
            "motherName"=>$request->motherName,
            "birthDay"=>$request->birthDay,
            "gender"=>$request->gender,
            "college"=>$colege[$request->college],
            "section"=>$request->section,
            "level"=>$request->level,
            "city"=>$request->city,
            "phoneNumber"=>$request->phoneNumber,
            "email"=>$request->email,
            "user_id"=>$user_id,
        ]);
        //save image
        if($request->image)
        {
            $image=$request->image;
            $newImageName=time().$image->getClientOriginalName();
            $image->move('assets/img/students',$newImageName);
            $student->image=$newImageName;
            $student->save();
        }
        else
        {
            if($request->gender=='ذكر')
            {
                $student->image="guest.jpg";
            }
            elseif($request->gender=='أنثى')
            {
                $student->image="guestF.webp";
            }
            $student->save();
        }
       
        return redirect()->route('home')->with('success','student Request added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //fetch student register request as user_id if user is student and as id if is admin

        if(Auth::user()->role==='0')
        {    
            $student=StudentReq::where('user_id',$id)->first();
        }
 
        else
        {
            $student=StudentReq::where('id',$id)->first();
        }
        
        //if the request is not found
        if($student==null)
        { 
            return redirect()->back()->withErrors('الطلب غير موجود');
        }

        //if the request is found but the Auth user is not Admin or this student is not that have this request
        if((Auth::user()->role==='0')&&($student->user_id !== Auth::id()))
        {
            return redirect()->back()->withErrors("هذا الإجراء يتطلب حساب مدير");
        }

        $colege= array("en"=>"الهندسة", "mng"=>"الإدارة والاقتصاد", "ed"=>"التربية", "law"=>"الشريعة والقانون", "hlth"=>"العلوم الصحية");
        
        //set student college as college short name 
        $student->college=array_search($student->college, $colege);
        $student->image="../assets/img/students/".$student->image;

        //if the Auth user is student take him to the page that show his request, if he want see or update it... 
        if(Auth::user()->role==='0')
        {
            return view('studentReq.show',['student'=>$student]);
        }

        //if the Auth user is Admin take him to the page that show the request where he can admit or reject it
        else
        {
            return view('studentReq.checkReq',['student'=>$student]);
        }
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit(studentReq $studentReq)
    {
        //the edit view is mixed with show view 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, studentReq $studentReq)
    {

        if((Auth::user()->role==='0')&&($studentReq->user_id !== Auth::id()))
        {
            return redirect()->back()->withErrors("you cannot access to another requests");
        }

        $colege= array("en"=>"الهندسة", "mng"=>"الإدارة والاقتصاد", "ed"=>"التربية", "law"=>"الشريعة والقانون", "hlth"=>"العلوم الصحية");

        $validated = $request->validate([
            "firstName"=>"required",
            "lastName"=>"required",
            "fatherName"=>"required",
            "motherName"=>"required",
            "birthDay"=>"required|date",
            "gender"=>"required",
            "college"=>"required",
            "section"=>"required",
            "level"=>"required|in:الأولى,الثانية,الثالثة,الرابعة",
            "city"=>"required",
            "phoneNumber"=>"required",
            "image"=>"image",
        ]);

        //mass assignment
        $studentReq->update([
            "firstName"=>$request->firstName,
            "lastName"=>$request->lastName,
            "fatherName"=>$request->fatherName,
            "motherName"=>$request->motherName,
            "birthDay"=>$request->birthDay,
            "gender"=>$request->gender,
            "college"=>$colege[$request->college],
            "section"=>$request->section,
            "level"=>$request->level,
            "city"=>$request->city,
            "phoneNumber"=>$request->phoneNumber,
        ]);

        //save image
        if($request->image)
        {
            $image=$request->image;
            $newImageName=time().$image->getClientOriginalName();
            $image->move('assets/img/students',$newImageName);
            $studentReq->image=$newImageName;
        }
        else
        {
            
            if($request->gender=='ذكر')
            {
                $studentReq->image="guest.jpg";
            }
            elseif($request->gender=='أنثى')
            {
                $studentReq->image="guestF.webp";
            }
            
        }
        $studentReq->save();
        return redirect()->back()->with('success','student request updated successfully');
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        $student=StudentReq::where('id',$id)->first();
        if($student==null)
        {
            return redirect()->back()->withErrors('not found');
        }

        if((Auth::user()->role==='0')&&($student->user_id !== Auth::id()))
        {
            return redirect()->back()->withErrors("you cannot access to another requests");
        }

        $student->delete();
        if(Auth::user()->role==0)
        {
            return redirect()->route('home')->withErrors('تم حذف الطلب بنجاح');
        }
        else
        {
            return redirect()->route('studentReq.index')->with('success','تم حذف الطلب بنجاح');
        }

    }
}
