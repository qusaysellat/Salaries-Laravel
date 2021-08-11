<?php

namespace App\Http\Controllers;

use App\PosChange;
use App\Position;
use App\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosChangeController extends Controller
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
        $position=Position::find($_GET['position_id']);
        if(isset($position)) {
            $changes = $position->changes;
            return view('pchanges', ['item'=>$position , 'changes' => $changes]);
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
        $position_id=$_GET['position_id'];
        return view('pchange',['position_id'=>$position_id]);
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
            'position_id'=>'required|exists:positions,id',
            'type'=>'required|boolean',
            'percentage'=>'required|boolean',
        ]);

        $temp=PosChange::create([
            'name'=>$request['name'],
            'value'=>$request['value'],
            'position_id'=>$request['position_id'],
            'type'=>$request['type'],
            'percentage'=>$request['percentage'],
        ]);
        $temp1=($temp->type==0)?'إضافة':'ضريبة';
        $temp2=($temp->percentage==0)?' ليرة':' بالمئة';
        $position=Position::find($request['position_id']);

        $audit=new AuditController();
        $type=1;
        $name=$position->name;
        $text='إنشاء '.$temp1.' بالاسم '.$request["name"].' بقيمة '.$request['value'].$temp2;
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);

        foreach($position->users as $user){
            $type=4;
            $text='إنشاء '.$temp1.' خاصة بالمستوى '.$position->name.' بالاسم '.$request["name"].' بقيمة '.$request['value'].$temp2;
            $user_id=$user->id;
            $audit->newAudit($type,'',$text,$user_id);
        }

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PosChange  $posChange
     * @return \Illuminate\Http\Response
     */
    public function show(PosChange $posChange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PosChange  $posChange
     * @return \Illuminate\Http\Response
     */
    public function edit(PosChange $posChange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PosChange  $posChange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosChange $posChange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PosChange  $posChange
     * @return \Illuminate\Http\Response
     */
    public function destroy($posChange)
    {
        $change=PosChange::find($posChange);
        $position=$change->position;

        $audit=new AuditController();
        $type=1;
        $name=$position->name;
        $text='حذف '.$change->name;
        $user_id=Auth::user()->id;

        foreach($position->users as $user){
            $type=4;
            $text='تم حذف '.$change->name.' الخاصة بالمستوى '.$position->name;
            $user_id=$user->id;
            $audit->newAudit($type,'',$text,$user_id);
        }

        PosChange::where('id',$posChange)->delete();
        $audit->newAudit($type,$name,$text,$user_id);
        return redirect()->route('positions.index');

    }
}
