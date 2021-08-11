<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
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
        $positions=Auth::user()->organization->positions;
        return view('positions',['positions'=>$positions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('position');
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
            'salary' => 'required|integer|min:1000',
        ]);

        $position=Position::create([
            'name'=>$request['name'],
            'salary'=>$request['salary'],
            'organization_id'=>Auth::user()->organization->id,
        ]);

        $audit=new AuditController();
        $type=1;
        $name=$position->name;
        $text='إنشاء مستوى وظيفي جديد براتب أساسي قدره '.$position->salary;
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('showposition',['position'=>$position]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        return view('editposition',['position'=>$position]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $validatedData = $request->validate([
            'salary' => 'required|integer|min:1000',
        ]);

        $temp=Position::where('id',$position->id)->update(['salary'=>$request['salary']]);

        $audit=new AuditController();
        $type=1;
        $name=$position->name;
        $text='تعديل الراتب الأساسي إلى '.$request['salary'];
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);

        foreach($position->users as $user){
            $type=4;
            $text='تعديل الراتب الأساسي '.' الخاص بالمستوى '.$position->name.' إلى '.$request['salary'];
            $user_id=$user->id;
            $audit->newAudit($type,'',$text,$user_id);
        }

        return redirect()->route('positions.show',['position'=>$position->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->changes()->delete();
        foreach($position->users as $user){
            $user->changes()->delete();
            $user->delete();
        }
        $position->delete();

        $audit=new AuditController();
        $type=1;
        $name=$position->name;
        $text='حذف ';
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);
        return redirect()->route('positions.index');
    }
}
