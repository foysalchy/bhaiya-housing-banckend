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
              ->orderBy('is_read', 'asc') 
            ->latest()
            ->get();

        return view('backend.contactList', compact('contacts', 'type'));
    }

// ContactController.php

    public function markAsRead($id)
    {
       $contact = Contact::find($id);
    
    if ($contact && !$contact->is_read) {
        $contact->update(['is_read' => true]);
    }

    return response()->json(['success' => true]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Contact deleted successfully.');
    }
}