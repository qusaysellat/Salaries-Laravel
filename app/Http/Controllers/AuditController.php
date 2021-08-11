<?php

namespace App\Http\Controllers;

use App\Audit;
use App\Organization;
use App\User;
use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=$_GET['id'];
        $type=intval($_GET['type']);
        if($type==1||$type==2){
            $item=Organization::find($id);
            if(isset($item)&&Auth::user()->role==0) {
                $user = User::find($item->manager_id);
                $audits=Audit::where('user_id',$user->id)->where('type',$type)->orderBy('created_at','desc')->get();
                if($type==1)
                    return view('positionAudits',['audits'=>$audits,'item'=>$item,'user'=>$user]);
                else
                    return view('branchAudits',['audits'=>$audits,'item'=>$item,'user'=>$user]);
            }
        }
        else if($type==3){
            $item=Branch::find($id);
            if(isset($item)&&Auth::user()->organization->id==$item->organization->id) {
                $user = User::find($item->accountant_id);
                $audits=Audit::where('user_id',$user->id)->where('type',$type)->orderBy('created_at','desc')->get();
                return view('employeeAudits',['audits'=>$audits,'item'=>$item,'user'=>$user]);
            }
        }
        return redirect()->back();
    }

    public function notifications(){
        $notifications=Audit::where('user_id',Auth::user()->id)->where('type',4)->orderBy('created_at','desc')->get();
        return view('notifications',['notifications'=>$notifications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function show(Audit $audit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function edit(Audit $audit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Audit $audit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audit $audit)
    {
        //
    }

    public function newAudit($type,$name,$text,$user_id){
        $audit=Audit::create([
            'type'=>$type,
            'name'=>$name,
            'text'=>$text,
            'user_id'=>$user_id,
        ]);

    }
}
