<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $this->middleware('auth')->except([
            'showLinkRequestForm',
            'sendResetLinkEmail',
            'showResetForm',
            'resetPassword'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function contactList()
    {
        $contacts = Contact::get();
        return view('backend.contactList', compact('contacts'));
    }
    public function toggleRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_read = !$contact->is_read; // Toggles between true and false
        $contact->save();

        return back()->with('success', 'Status updated successfully');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('success', 'Contact deleted successfully');
    }
    public function userIndex()
    {
        if (Gate::denies('admin-only')) {
            abort(403);
        }
        $users = User::latest()->get();
        return view('backend.users.index', compact('users'));
    }

    public function userForm($id = null)
    {
        if (!$id && Gate::denies('admin-only')) {
            abort(403);
        }
        if ($id && auth()->id() != $id && Gate::denies('admin-only')) {
            abort(403);
        }

        $user = $id ? User::findOrFail($id) : new User();

        $mode = 'create';
        if (request()->routeIs('admin.users.show')) $mode = 'view';
        if (request()->routeIs('admin.users.edit')) $mode = 'edit';

        return view('backend.users.create', compact('user', 'mode'));
    }

    public function adminStoreUser(Request $request)
    {
        if (Gate::denies('admin-only')) {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User Created Successfully!');
    }

    public function userUpdate(Request $request, $id)
    {
        if (Gate::denies('admin-only')) {
            abort(403);
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User Updated Successfully!');
    }

    public function userDestroy($id)
    {
        if (Gate::denies('admin-only')) {
            abort(403);
        }

        $user = User::findOrFail($id);
        if (auth()->id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return back()->with('status', 'User deleted successfully!');
    }
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            Http::withHeaders([
                'X-API-Key' => config('services.mailer.key'),
            ])->post(config('services.mailer.url'), [
                'type'    => 'verification',
                'to'      => $request->email,
                'subject' => 'Reset Your Password',
                'data'    => [
                    'eyebrow'           => 'Security',
                    'heading'           => 'Password Reset Request',
                    'name'              => 'User',
                    'message'           => 'We received a request to reset your password. Click the button below to set a new one. This link is valid for 60 minutes.',
                    'button_text'       => 'Reset Password',
                    'verification_link' => $resetLink,
                ],
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Could not send email. Please try again.']);
        }

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset')->with(['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Invalid token or email address.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
        }

        $user->save();

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        Auth::login($user);

        return redirect()->route('home')->with('status', 'Your password has been reset and you are now logged in!');
    }
    public function changePasswordView()
    {
        return view('auth.passwords.change-password');
    }

    public function updatePasswordLoggedIn(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('status', 'Password changed successfully!');
    }

}
