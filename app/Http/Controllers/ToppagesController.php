<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LessonSchedule;
use App\Models\Lesson;

class ToppagesController extends Controller
{
    public function index() {
        if(Auth::check()) {
            return redirect()->route('lesson-schedules.index');
        } else {
            return view('welcome');
        }
    }
}
