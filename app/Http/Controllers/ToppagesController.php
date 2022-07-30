<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LessonSchedule;
use App\Lesson;

class ToppagesController extends Controller
{
    public function index() {
        if(Auth::check()) {
            if (Auth::user()->is_admin == 1) {
                return redirect()->route('lesson-schedules.index');
            } elseif (Auth::user()->is_admin == 0) {
                return view('welcome');
            }
        } else {
            return view('welcome');
        }
    }
}
