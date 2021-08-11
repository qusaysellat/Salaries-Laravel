<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use App\User;
use App\Audit;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //نسمح فقط للمستخدم مسجل الدخول الولوج الى هذا الكونترولر
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewName = $this->getViewName();
        $item=$this->getItem();
        //ارجع فيو اسمه حسب نوع المستخدم مسجل الدخول
        return view($viewName,['item'=>$item]);
    }

    private function getViewName()
    {
        $user = Auth::user();
        //استدعاء الطريقة يوسر من الصف الخاص بوظائف تسجيل المستخدمين
        $type = $user->role;
        $ans = '';
        if ($type == 0)
            $ans = 'admin';
        else if ($type == 1)
            $ans = 'manager';
        else if ($type == 2)
            $ans = 'accountant';
        else if ($type == 3)
            $ans = 'employee';
        else if ($type == 4)
            $ans = 'observer';
        return $ans;
    }

    private function getItem()
    {
        $user = Auth::user();
        //استدعاء الطريقة يوسر من الصف الخاص بوظائف تسجيل المستخدمين
        $type = $user->role;
        $ans = '';
        if ($type == 0)
            $ans = '';
        else if ($type == 1)
            $ans = Auth::user()->organization;
        else if ($type == 2)
            $ans = Auth::user()->branch;
        else if ($type == 3)
            $ans = '';
        else if ($type == 4)
            $ans = '';
        return $ans;
    }
}
