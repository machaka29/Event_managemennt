<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SystemSetting;

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
            SystemSetting::set($key, $value);
        }

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'system_logo' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        if ($request->hasFile('system_logo')) {
            // Delete old logo if exists
            $oldLogo = SystemSetting::get('system_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('system_logo')->store('system', 'public');
            SystemSetting::set('system_logo', $path);
        }

        return back()->with('success', 'System logo updated successfully.');
    }
}
