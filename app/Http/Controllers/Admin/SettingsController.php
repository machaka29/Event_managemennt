<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'system_name' => 'required|string|max:255',
            'system_email' => 'required|email|max:255',
            'system_footer' => 'required|string|max:255',
        ]);
        
        foreach ($data as $key => $value) {
            \App\Models\SystemSetting::set($key, $value);
        }

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }
}
