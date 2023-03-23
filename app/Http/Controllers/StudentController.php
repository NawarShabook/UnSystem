<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentReq;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**controller middleware */
    // public function _construct()
    // {
    // $this->middleware('auth')->except(['index' ,'show']);
    // $this->middleware('auth')->only(['store' ,'create']);
    
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students=Student::all();
        return view('students.index',['students'=>$students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {  
        //fetch name and email of student users 
        $studentUsers=User::where('role',0)->get();

      
        return view('students.create', ['users'=>$studentUsers]);

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
            "room"=>"required|integer",
            "phoneNumber"=>"required",
            "email"=>"required|email",
            "image"=>"image",
        ]);

        //fech email that related to this user with student role
        $std_user=User::where('role', 0)->where('email', $request->email)->first();
        
        //if this email student not found
        if($std_user==null)
        {
            return redirect()->back()->withErrors("حساب الطالب المرتبط بهذا الإيميل غير موجود");
        }

        //if this student exist in database
        elseif($std_user->student)
        {
            return redirect()->back()->withErrors("الطالب المرتبط بهذا الإيميل موجود مسبقا في قاعدة البيانات");
        }

        

        //mass assignment
        $student=Student::create([
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
            "room"=>$request->room,
            "phoneNumber"=>$request->phoneNumber,
            "email"=>$request->email,
            "user_id"=>$std_user->id,
        ]);

        //save image, if request has image 
        if($request->image)
        {
           
            $image=$request->image;
            $newImageName=time().$image->getClientOriginalName();

            $image->move('assets/img/students',$newImageName);
            $student->image=$newImageName;
            $student->save();
        }
        //if request not has image set default image as gender
        //and handling if request is from register request student, maybe has image
        else
        {
            //if this store action is from register request test if request have image
            if($request->oldReqId)
            {
                $old_req=StudentReq::select('id', 'image')->where('id', $request->oldReqId)->first();

                //if id of request register is found 
                if($old_req)
                {

                    $student->image=$old_req->image;
                    $student->save();
                }
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
        }

        //if this store action is from register request delete this request
        if($request->oldReqId)
        {
            $old_req=StudentReq::where('id', $request->oldReqId)->first();
            //if id of request register is found 
            if($old_req)
            {
                $old_req->delete();
            }
        }
       
        return redirect()->route('student.index')->with('success','student added successfully');
    }

    /** dd
     * Display the specified resource.
     */
    public function show($id)
    {
       
        if(Auth::user()->role==='0')
        {    
            $student=Student::where('user_id',$id)->first();
        }
 
        else
        {
            $student=Student::where('id',$id)->first();
        }
        
        $colege= array("en"=>"الهندسة", "mng"=>"الإدارة والاقتصاد", "ed"=>"التربية", "law"=>"الشريعة والقانون", "hlth"=>"العلوم الصحية");
        

        if($student==null)
        {
            return redirect()->back()->withErrors('the student not found');
        }
     
        if((Auth::user()->role==='0')&&($student->user_id !== Auth::id()))
        {
            return redirect()->route('/home')->withErrors("هذا الإجراء يتطلب حساب مدير");
        }
        $student->image='../assets/img/students/'.$student->image;
        $student->college=array_search($student->college, $colege);
        return view('students.show',['student'=>$student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //the edit view is mixed with show view
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
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
            "room"=>"required|integer",
            "phoneNumber"=>"required",
            "email"=>"required|email",
            "image"=>"image",
        ]);

        
        

        //mass assignment
        $student->update([
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
            "room"=>$request->room,
            "phoneNumber"=>$request->phoneNumber,
            "email"=>$request->email,
        ]);
        //save image
        if($request->image)
        {
            $image=$request->image;
            $newImageName=time().$image->getClientOriginalName();
            $image->move('assets/img/students',$newImageName);
            $student->image=$newImageName;
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
            
        }
        $student->save();
        return redirect()->back()->with('success','student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {;
        $student=Student::where('id',$id)->first();
        if($student==null)
        {
            return redirect()->back();
        }
        // if($student->image!='guest' && $student->image!='guestF')
        // {
        //     Storage::delete(public_path('assets/img/students/' . $student->image));
         
        // }

        $student->delete();
        return redirect()->route('student.index')->with('success','student deleted successfully');
    }
}
