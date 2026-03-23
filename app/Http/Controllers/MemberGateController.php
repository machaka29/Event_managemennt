<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;

class MemberGateController extends Controller
{
    /**
     * Show the member entry gate.
     */
    public function showGate()
    {
        return view('public.gate');
    }

    /**
     * Verify the member access code.
     */
    public function verifyGate(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        $attendee = Attendee::where('access_code', $request->access_code)->first();

        if ($attendee) {
            session(['member_access_id' => $attendee->access_code]);
            return redirect()->route('events.index')->with('success', 'Access granted. Welcome back, ' . $attendee->full_name);
        }

        return back()->withErrors(['access_code' => 'Invalid Access ID. Please contact the administrator.']);
    }

    /**
     * Clear the member session.
     */
    public function logout()
    {
        session()->forget('member_access_id');
        return redirect()->route('member.gate')->with('success', 'You have been logged out.');
    }
}
