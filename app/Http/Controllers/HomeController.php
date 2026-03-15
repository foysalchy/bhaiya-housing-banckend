<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Content;

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

}
