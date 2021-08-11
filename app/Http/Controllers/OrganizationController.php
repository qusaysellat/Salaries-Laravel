<?php

namespace App\Http\Controllers;

use App\Organization;
use App\User;
use App\Audit;
use Illuminate\Http\Request;

class OrganizationController extends Controller
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
        $organizations=Organization::select('id','name')->get();
        return view('organizations',['organizations'=>$organizations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organization');
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
            'manager' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name'=>'required|string|max:255',
            'address' => 'nullable|string|max:2000',
            'phone'=>'nullable|string|unique:organizations',
            'fax'=>'nullable|string|unique:organizations',
            'email'=>'nullable|email|unique:organizations',
        ]);

        $organization=Organization::create([
            'name'=>$request['name'],
            'address'=>$request['address'],
            'phone'=>$request['phone'],
            'fax'=>$request['fax'],
            'email'=>$request['email'],
        ]);

        $user=User::create([
            'name'=>$request['manager'],
            'username'=>$request['username'],
            'password'=>bcrypt($request['password']),
            'role'=> 1,
            'position_id'=>0,
            'branch_id'=>0,
            'organization_id'=>$organization->id,
        ]);

        $organization->manager_id=$user->id;
        $organization->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $user=User::find($organization->manager_id);
        return view('showorganization',['organization'=>$organization,'user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        return view('editorganization',['organization'=>$organization]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $validatedData = $request->validate([
            'manager' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user=User::where('organization_id',$organization->id)
            ->where('role',1)
            ->update([
                'name'=>$request['manager'],
                'username'=>$request['username'],
                'password'=>bcrypt($request['password']),
            ]);
        return redirect()->route('organizations.show',['organization'=>$organization->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $organization->observers()->detach();
        foreach($organization->branches as $branch){
            foreach($branch->users as $user){
                $user->changes()->delete();
                $user->delete();
            }
            $branch->delete();
        }
        foreach($organization->positions as $position){
            $position->changes()->delete();
            $position->delete();
        }
        $organization->users()->delete();
        $organization->delete();
        return redirect()->route('organizations.index');
    }
}
