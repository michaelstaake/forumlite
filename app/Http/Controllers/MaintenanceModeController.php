<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Settings;

class MaintenanceModeController extends Controller
{
    public function view() {
        $maintenance_mode = Settings::where('setting', 'maintenance_mode')->first();
		$maintenance_mode = $maintenance_mode->value;

        if ($maintenance_mode === "enabled") {
            $maintenance_message = Settings::where('setting', 'maintenance_message')->first();
            $maintenance_message = $maintenance_message->value;
            return view('maintenancemode')->with('maintenance_message', $maintenance_message);
        } else {
            return redirect('/');
        }
       
    }
}
