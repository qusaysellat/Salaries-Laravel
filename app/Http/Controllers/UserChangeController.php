<?php

namespace App\Http\Controllers;

use App\UserChange;
use Illuminate\Http\Request;
use App\User;
use App\Audit;
use Illuminate\Support\Facades\Auth;

class UserChangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee=User::find($_GET['employee_id']);
        if(isset($employee)) {
            $changes = $employee->changes;
            return view('uchanges', ['item'=>$employee , 'changes' => $changes]);
        }
        else
            return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee_id=$_GET['employee_id'];
        return view('uchange',['employee_id'=>$employee_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'employee_id'=>'required|exists:users,id',
            'type'=>'required|boolean',
            'percentage'=>'required|boolean',
        ]);

        $tempuser=User::find($request['employee_id']);
        if($tempuser->role==3) {
            $temp = UserChange::create([
                'name' => $request['name'],
                'value' => $request['value'],
                'user_id' => $request['employee_id'],
                'type' => $request['type'],
                'percentage' => $request['percentage'],
            ]);

            $temp1=($temp->type==0)?'إضافة':'حسمية';
            $temp2=($temp->percentage==0)?' ليرة':' بالمئة';
            $employee=User::find($request['employee_id']);

            $audit=new AuditController();
            $type=3;
            $name=$employee->name;
            $text='إنشاء '.$temp1.' بالاسم '.$request["name"].' بقيمة '.$request['value'].$temp2;
            $user_id=Auth::user()->id;
            $audit->newAudit($type,$name,$text,$user_id);

            $type=4;
            $text='إنشاء '.$temp1.' بالاسم '.$request["name"].' بقيمة '.$request['value'].$temp2;
            $user_id=$employee->id;
            $audit->newAudit($type,'',$text,$user_id);

            return redirect()->route('home');
        }
        else
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserChange  $userChange
     * @return \Illuminate\Http\Response
     */
    public function show(UserChange $userChange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserChange  $userChange
     * @return \Illuminate\Http\Response
     */
    public function edit(UserChange $userChange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserChange  $userChange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserChange $userChange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserChange  $userChange
     * @return \Illuminate\Http\Response
     */
    public function destroy($userChange)
    {
        $change=UserChange::find($userChange);
        $user=$change->user;
        $audit=new AuditController();
        $type=3;
        $name=$user->name;
        $text='حذف '.$change->name;
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);

        $type=4;
        $text='تم حذف '.$change->name;
        $user_id=$user->id;
        $audit->newAudit($type,'',$text,$user_id);


        UserChange::where('id',$userChange)->delete();
        return redirect()->route('employees.index');
    }
}
