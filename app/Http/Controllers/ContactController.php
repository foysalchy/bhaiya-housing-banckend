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

        $blockedIps = \App\Models\BlockedIp::pluck('ip_address')->toArray(); return view('backend.contactList', compact('contacts', 'type', 'blockedIps'));
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

    public function blockIp(Request $request)
    {
        $request->validate(['ip_address' => 'required|ip']);
        \App\Models\BlockedIp::firstOrCreate(['ip_address' => $request->ip_address]);
        return back()->with('success', 'IP address has been blocked successfully.');
    }

    public function unblockIp(Request $request)
    {
        $request->validate(['ip_address' => 'required|ip']);
        \App\Models\BlockedIp::where('ip_address', $request->ip_address)->delete();
        return back()->with('success', 'IP address has been unblocked successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->input('ids'), true);
        if (is_array($ids) && count($ids) > 0) {
            Contact::whereIn('id', $ids)->delete();
            $count = count($ids); return back()->with('success', "$count contacts deleted successfully.");
        }
        return back()->withErrors(['message' => 'No contacts selected.']);
    }

    public function bulkBlock(Request $request)
    {
        $ids = json_decode($request->input('ids'), true);
        if (is_array($ids) && count($ids) > 0) {
            $ips = Contact::whereIn('id', $ids)->whereNotNull('ip_address')->pluck('ip_address')->unique();
            foreach ($ips as $ip) {
                \App\Models\BlockedIp::firstOrCreate(['ip_address' => $ip]);
            }
            $count = count($ips); return back()->with('success', "$count IPs blocked successfully.");
        }
        return back()->withErrors(['message' => 'No valid IPs selected to block.']);
    }

    public function exportCsv(Request $request)
    {
        $ids = json_decode($request->input('ids'), true);
        
        $query = Contact::query();
        if (is_array($ids) && count($ids) > 0) {
            $query->whereIn('id', $ids);
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();

        $fileName = 'contacts_export_' . date('Y-m-d') . '.xls';
        
        $headers = [
            "Content-type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($contacts) {
            echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
            echo '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Contacts</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
            echo '</head><body>';
            echo '<table border="1" cellpadding="5" cellspacing="0">';
            echo '<thead style="background-color: #f1f3f4; font-weight: bold;">';
            echo '<tr>';
            echo '<th style="width: 50px;">ID</th>';
            echo '<th style="width: 100px;">Type</th>';
            echo '<th style="width: 150px;">Name</th>';
            echo '<th style="width: 180px;">Email</th>';
            echo '<th style="width: 120px;">Phone</th>';
            echo '<th style="width: 150px;">Designation</th>';
            echo '<th style="width: 120px;">Budget</th>';
            echo '<th style="width: 150px;">Subject</th>';
            echo '<th style="width: 300px;">Message</th>';
            echo '<th style="width: 150px;">Date</th>';
            echo '</tr>';
            echo '</thead><tbody>';

            foreach ($contacts as $contact) {
                $date = $contact->created_at ? $contact->created_at->format('d M Y, h:i A') : '';
                echo '<tr>';
                echo '<td>' . $contact->id . '</td>';
                echo '<td>' . ucfirst($contact->type) . '</td>';
                echo '<td>' . htmlspecialchars($contact->name ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($contact->email ?? '') . '</td>';
                echo '<td>&nbsp;' . htmlspecialchars($contact->phone ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($contact->designation ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($contact->estimate_budget ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($contact->subject ?? '') . '</td>';
                echo '<td>' . nl2br(htmlspecialchars($contact->message ?? '')) . '</td>';
                echo '<td>' . $date . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}
