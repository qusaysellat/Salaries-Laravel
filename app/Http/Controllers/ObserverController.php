<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use App\User;

class ObserverController extends Controller
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
        $observers = User::select('id', 'name')->where('role', 4)->get();
        return view('observers', ['observers' => $observers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createobserver');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'nullable|string|max:2000',
            'phone' => 'nullable|string|unique:users',
            'email' => 'nullable|email|unique:users',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => bcrypt($request['password']),
            'role' => 4,
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'position_id' => 0,
            'branch_id' => 0,
            'organization_id' => 0,
        ]);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $observer = User::find($id);

        if (isset($observer)) {
            $organizations = Organization::select('id', 'name')->get();
            $observed = array();
            foreach ($organizations as $organization) {
                $observed[$organization->id] = 0;
            }
            foreach ($observer->observed as $org) {
                $observed[$org->id] = 1;
            }
            return view('showobserver', ['observer' => $observer, 'observed' => $observed, 'organizations' => $organizations]);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'action' => 'required',
            'organization' => 'required|exists:organizations,id',
        ]);
        $observer=User::find($id);
        if (isset($observer)) {
            $is=intval($request['action']);
            $organization_id=$request['organization'];
            if($is==1)
                $observer->observed()->detach([$organization_id]);
                else if($is==0)
                    $observer->observed()->attach([$organization_id]);
            return redirect()->route('observers.show',['id'=>$id]);
        } else
            return redirect()->route('home');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $observer = User::find($id);
        if (isset($observer)) {
            $observer->observed()->detach();
            $observer->delete();
            return redirect()->route('observers.index');
        } else
            return redirect()->route('home');
    }
}
