<?php

namespace App\Http\Controllers;

use App\Models\Bagging;
use App\Models\ControlPollination;
use App\Models\Harvest;
use App\Models\Pollen;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $motherpalm['balut']['hariini'] = Bagging::whereDate('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Motherpalm');
        })->count();

        $motherpalm['balut']['hinggakini'] = Bagging::whereMonth('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Motherpalm');
        })->count();

        $motherpalm['debung']['hariini'] = Pollen::whereDate('created_at', Carbon::today())->count();
        $motherpalm['debung']['hinggakini'] = Pollen::whereMonth('created_at', Carbon::today())->count();

        $motherpalm['kawal']['hariini'] = ControlPollination::whereDate('created_at', Carbon::today())->count();
        $motherpalm['kawal']['hinggakini'] = ControlPollination::whereMonth('created_at', Carbon::today())->count();

        $motherpalm['tuai']['hariini'] = Harvest::whereDate('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Motherpalm');
        })->count();
        $motherpalm['tuai']['hinggakini'] = Harvest::whereMonth('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Motherpalm');
        })->count();

        $fatherpalm['balut']['hariini'] = Bagging::whereDate('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Fatherpalm');
        })->count();
        $fatherpalm['balut']['hinggakini'] = Bagging::whereMonth('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Fatherpalm');
        })->count();

        $fatherpalm['tuai']['hariini'] = Harvest::whereDate('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Fatherpalm');
        })->count();
        $fatherpalm['tuai']['hinggakini'] = Harvest::whereMonth('created_at', Carbon::today())->whereHas('pokok', function ($q) {
            return $q->where('jantina', 'Fatherpalm');
        })->count();

        return view('dashboard', compact('motherpalm', 'fatherpalm'));
    }

    public function test()
    {
        $u1 = User::find(14);
        $u1->attachRole('worker');
        $u1 = User::find(15);
        $u1->attachRole('supervisor');

    }

    public function temp()
    {
        $user = User::all();

        foreach ($user as $u) {
            $u->update([
                'password' => Hash::make('INIT123'),
            ]);
        }

    }
}
