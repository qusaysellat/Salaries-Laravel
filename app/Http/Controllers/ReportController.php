<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\Position;
use App\Branch;
use App\User;
use App\PosChange;
use App\UserChange;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function report(Organization $organization)
    {
        if ($this->isLegal($organization) == false)
            return redirect()->back();

        return view('report', ['organization' => $organization]);
    }

    public function showReport(Request $request)
    {
        $validatedData = $request->validate([
            'branch' => 'required|integer|min:0',
            'position' => 'required|integer|min:0',
            'organization' => 'required|exists:organizations,id',
        ]);
        $organization = Organization::find($request['organization']);

        if ($this->isLegal($organization) == false)
            return redirect()->back();

        $p = $request['position'];
        $b = $request['branch'];
        $info = array();
        if ($b == 0) {
            foreach ($organization->branches as $branch) {
                $info[$branch->id] = array();
            }
        } else {
            $branch = Branch::find($b);
            if (!isset($branch))
                return redirect()->back();
            $bname = $branch->name;
            $info[$branch->id] = array();
        }
        foreach ($info as $branch => $value) {
            if ($p == 0) {
                foreach ($organization->positions as $position) {
                    $info[$branch][$position->id] = array();
                }
            } else {
                $position = Position::find($p);
                if (!isset($position))
                    return redirect()->back();
                $pname = $position->name;
                $info[$branch][$position->id] = array();
            }
            $branch_obj = Branch::find($branch);
            $info[$branch][0] = $branch_obj->name;
        }

        $cnt = 0;
        $total1 = 0;
        $total2 = 0;
        foreach ($info as $bid => $positions) {
            foreach ($positions as $pid => $details) {
                if ($bid == 0 || $pid == 0) continue;
                $branch = Branch::find($bid);
                $position = Position::find($pid);
                $is = ($b > 0 && $p > 0) ? true : false;

                $info[$bid][$pid] = $this->computedetails($branch, $position, $is);
                $info[$bid][$pid][0] = $position->name;
                $details = $info[$bid][$pid];

                $cnt += $details['empcnt'];
                $total1 += $details['total1'];
                $total2 += $details['total2'];

            }
        }

        if($p==0)$pname=' كل المستويات ';
        if($b==0)$bname=' كل الفروع ';
        return view('showreport', [
            'info' => $info,
            'organization' => $organization,
            'cnt' => $cnt, 'total1' => $total1,
            'total2' => $total2,
            'pname' => $pname,
            'bname' => $bname,
        ]);
    }

    private function computedetails(Branch $branch, Position $position, $is)
    {
        $cnt = User::where('branch_id', $branch->id)->where('position_id', $position->id)->count();
        $details['empcnt'] = $cnt;
        $salary = $position->salary;
        $total2 = $cnt * $salary;
        $details['total1'] = $total2;
        $poschanges = 0;
        $empchanges = 0;
        $array1 = array();
        $array2 = array();
        foreach ($position->changes as $change) {
            $type = ($change->type == 0) ? 1.0 : -1.0;
            $temp = ($change->percentage == 0) ? $change->value : ($change->value) * 0.01 * $salary;
            $poschanges += $cnt * $type * $temp;
            $total2 += $cnt * $type * $temp;
            $array1[$change->id] = array('id' => $change->id, 'name' => $change->name, 'type' => $change->type, 'percentage' => $change->percentage, 'value' => $change->value, 'realvalue' => $type*$temp, 'finalvalue' => $cnt * $type * $temp);
        }
        $details['totalposchanges'] = $poschanges;
        $details['poschanges'] = $array1;
        $employees = User::where('branch_id', $branch->id)->where('position_id', $position->id)->get();
        foreach ($employees as $employee) {
            foreach ($employee->changes as $change) {
                $type = ($change->type == 0) ? 1.0 : -1.0;
                $temp = ($change->percentage == 0) ? $change->value : ($change->value) * 0.01 * $salary;
                $empchanges += $temp * $type;
                $total2 += $temp * $type;
                if ($is) {
                    $array2[$change->id] = array('id' => $change->id, 'emp' => $employee->name, 'name' => $change->name, 'type' => $change->type, 'percentage' => $change->percentage, 'value' => $change->value, 'realvalue' => $type*$temp);
                }
            }
        }
        $details['totalempchanges'] = $empchanges;
        if ($is) {
            $details['empchanges'] = $array2;
        }
        $details['total2'] = $total2;
        return $details;

    }


    private function isLegal(Organization $organization)
    {
        if(Auth::user()->role==0)return true;
        $user=Auth::user();
        foreach ($user->observed as $item) {
            if($item->id==$organization->id)return true;
        }
        return false;
    }
}
