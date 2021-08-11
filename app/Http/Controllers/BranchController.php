<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use App\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BranchController extends Controller
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
        $branches=Auth::user()->organization->branches;
        return view('branches',['branches'=>$branches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branch');
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
            'address' => 'nullable|string|max:2000',
            'phone'=>'nullable|string|unique:branches',
            'fax'=>'nullable|string|unique:branches',
            'email'=>'nullable|email|unique:branches',
            'manager' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $branch=Branch::create([
            'name'=>$request['name'],
            'address'=>$request['address'],
            'phone'=>$request['phone'],
            'fax'=>$request['fax'],
            'email'=>$request['email'],
            'organization_id'=>Auth::user()->organization->id,
        ]);

        $user=User::create([
            'name'=>$request['manager'],
            'username'=>$request['username'],
            'password'=>bcrypt($request['password']),
            'role'=> 2,
            'position_id'=>0,
            'branch_id'=>$branch->id,
            'organization_id'=>$branch->organization->id,
        ]);

        $branch->accountant_id=$user->id;
        $branch->save();

        $audit=new AuditController();
        $type=2;
        $name=$branch->name;
        $text='إنشاء فرع جديد بمدير رواتب اسمه '.$user->name;
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        $user=User::find($branch->accountant_id);
        return view('showbranch',['branch'=>$branch,'user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        return view('editbranch',['branch'=>$branch]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $validatedData = $request->validate([
            'manager' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user=User::where('branch_id',$branch->id)
            ->where('role',2)
            ->update([
                'name'=>$request['manager'],
                'username'=>$request['username'],
                'password'=>bcrypt($request['password']),
            ]);

        $audit=new AuditController();
        $type=2;
        $name=$branch->name;
        $text='إنشاء مدير رواتب جديد اسمه '.$request['manager'];
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);
        return redirect()->route('branches.show',['branch'=>$branch->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        foreach($branch->users as $user){
            $user->changes()->delete();
            $user->delete();
        }
        $branch->delete();
        $audit=new AuditController();
        $type=2;
        $name=$branch->name;
        $text='حذف ';
        $user_id=Auth::user()->id;
        $audit->newAudit($type,$name,$text,$user_id);

        return redirect()->route('branches.index');
    }
}
