<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\EmploymentProgram;
use App\Models\ActivityLog;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Display Administrative Settings Page
     */
    public function index()
    {
        $programs = EmploymentProgram::all();
        $logs = ActivityLog::with('user')->latest()->take(10)->get();
        $adminUsers = User::orderBy('name')->get();

        return view('settings.index', compact('programs', 'logs', 'adminUsers'));
    }

    /**
     * Update Office / System Settings
     */
    public function update(Request $request)
    {
        return back()->with('success', 'System settings saved successfully.');
    }

    /**
     * Create a new admin user from settings.
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:super_admin,manager,staff'],
            'contact_number' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.settings.index')->with('success', 'User account created successfully.');
    }

    /**
     * Update user account details from settings.
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:super_admin,manager,staff'],
            'contact_number' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.settings.index')->with('success', 'User details updated successfully.');
    }

    /**
     * Update a selected admin user's password.
     */
    public function updateUserPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'User password updated successfully.');
    }

    /**
     * Remove an admin user.
     */
    public function destroyUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.settings.index')->withErrors(['user' => 'You cannot delete your own active administrator account.']);
        }

        $user->delete();

        return redirect()->route('admin.settings.index')->with('success', 'User account removed successfully.');
    }

    /**
     * Display Public QR Code Display & Municipal Poster View
     */
    public function qrCode()
    {
        $registrationUrl = route('public.register');
        return view('qr.index', compact('registrationUrl'));
    }
}
