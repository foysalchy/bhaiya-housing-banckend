<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'all');

        $contacts = Contact::query()
            ->when($type !== 'all', fn($q) => $q->where('type', $type))
            ->latest()
            ->get();

        return view('backend.contactList', compact('contacts', 'type'));
    }

    public function toggleRead(Contact $contact)
    {
        $contact->update(['is_read' => !$contact->is_read]);

        return back()->with('success', 'Contact status updated.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Contact deleted successfully.');
    }
}