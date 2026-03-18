<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage;

class SystemSettingController extends Controller
{
    public function updateLogo(Request $request)
    {
        $request->validate([
            'system_logo' => ['required', 'image', 'max:1024'], // 1MB max
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
