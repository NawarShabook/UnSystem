<?php

namespace App\Http\Controllers;

use App\Models\StudentReq;
use Illuminate\Http\Request;

class StudentReqController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function _construct()
    {
        $this->middleware('isAdmin')->only(['store' ,'create']);
    }
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
        return view('studentReq.create');
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
        ]);
        //save image
        if($request->image)
        {
            $image=$request->image;
            $newImageName=time().$image->getClientOriginalName();
            $image->move('assets/img/students',$newImageName);
            $student->image='../assets/img/students/'.$newImageName;
            $student->save();
        }
        else
        {
            if($request->gender=='ذكر')
            {
                $student->image="../assets/img/students/guest.jpg";
            }
            elseif($request->gender=='أنثى')
            {
                $student->image="../assets/img/students/guestF.webp";
            }
            $student->save();
        }
       

        return redirect()->back()->with('success','student added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $colege= array("en"=>"الهندسة", "mng"=>"الإدارة والاقتصاد", "ed"=>"التربية", "law"=>"الشريعة والقانون", "hlth"=>"العلوم الصحية");
        
        $student=StudentReq::where('id',$id)->first();
        if($student==null)
        {
            return redirect()->back()->with('errors','the student not found');
        }
        $student->college=array_search($student->college, $colege);
        return view('studentReq.show',['student'=>$student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(studentReq $studentReq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, studentReq $studentReq)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student=StudentReq::where('id',$id)->first();
        if($student==null)
        {
            return redirect()->back();
        }
        $student->delete();
        return redirect()->back()->with('success','student request deleted successfully');
    }
}
