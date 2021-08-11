<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Position;
use App\Audit;

class EmployeeController extends Controller
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
        $employees = User::where('role', 3)->where('branch_id', Auth::user()->branch->id)->get();
        return view('employees', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::select('id', 'name')->where('organization_id', Auth::user()->organization->id)->get();
        return view('createemployee', ['positions' => $positions]);
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
            'position_id' => 'required|exists:positions,id',
            'address' => 'nullable|string|max:2000',
            'phone' => 'nullable|string|unique:users',
            'email' => 'nullable|email|unique:users',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => bcrypt($request['password']),
            'role' => 3,
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'position_id' => $request['position_id'],
            'branch_id' => Auth::user()->branch->id,
            'organization_id' => Auth::user()->organization->id,
        ]);

        $position = Position::find($request['position_id']);
        $audit = new AuditController();
        $type = 3;
        $name = $user->name;
        $text = 'إنشاء موظف جديد برقم ضمان اجتماعي ' . $user->username . ' ومستوى وظيفي ' . $position->name;
        $user_id = Auth::user()->id;
        $audit->newAudit($type, $name, $text, $user_id);

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
        $employee = User::find($id);
        if (isset($employee)) {
            $changes1 = array();
            $changes2 = array();
            $salary = $employee->position->salary;
            $total=$salary;
            foreach ($employee->position->changes as $change) {
                $type=($change->type==0)?1.0:-1.0;
                $temp=($change->percentage == 0) ? $change->value : ($change->value) * 0.01 * $salary;
                $changes1[$change->id] = $temp*$type;
                $total+=$temp*$type;
            }
            foreach ($employee->changes as $change) {
                $type=($change->type==0)?1.0:-1.0;
                $temp=($change->percentage == 0) ? $change->value : ($change->value) * 0.01 * $salary;
                $changes2[$change->id] = $temp*$type;
                $total+=$temp*$type;
            }
            return view('showemployee', ['employee' => $employee, 'changes1' => $changes1, 'changes2' => $changes2,'total'=>$total,'salary'=>$salary]);
        } else
            return redirect()->route('home');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = User::find($id);
        if (isset($employee)) {
            $employee->changes()->delete();
            $employee->delete();
            $audit = new AuditController();
            $name = $employee->name;
            $type = 3;
            $text = 'حذف ';
            $user_id = Auth::user()->id;
            $audit->newAudit($type, $name, $text, $user_id);
            return redirect()->route('employees.index');
        } else
            return redirect()->route('home');
    }
}
