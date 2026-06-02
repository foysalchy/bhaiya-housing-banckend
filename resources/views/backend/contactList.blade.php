@extends('layouts.backend')
@section('content')

<style>
/* ══════════════════════════════════════════
   Gmail-style Split Pane — Contact Inbox
══════════════════════════════════════════ */
* { box-sizing: border-box; }

.gmail-wrap {
    display: flex;
    height: calc(100vh - 80px);
    background: #f6f8fc;
    font-family: 'Google Sans', Roboto, sans-serif;
    gap: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 12px;
}

/* ── LEFT PANEL ── */
.inbox-list {
    width: 380px;
    min-width: 280px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    background: #fff;
    border-right: 1px solid #e8eaed;
    overflow: hidden;
}

.inbox-header {
    padding: 14px 16px 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.inbox-header h6 {
    font-size: 15px;
    font-weight: 600;
    color: #202124;
    margin: 0;
}

.badge-count {
    background: #1a73e8;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
}

/* ── FILTER & SEARCH ── */
.inbox-filters {
    padding: 0 16px 10px;
    display: flex;
    gap: 8px;
}

.filter-chip {
    font-size: 12px;
    padding: 5px 12px;
    border-radius: 16px;
    background: #f1f3f4;
    color: #5f6368;
    cursor: pointer;
    user-select: none;
    border: 1px solid transparent;
    transition: all 0.2s;
    display: inline-block;
    font-weight: 500;
}

.filter-chip input { display: none; }

/* When radio button inside label is checked */
.filter-chip:has(input:checked) {
    background: #e8f0fe;
    color: #1a73e8;
    border-color: #1a73e8;
}

.inbox-search {
    padding: 0 16px 12px;
    border-bottom: 1px solid #e8eaed;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input-wrapper svg {
    position: absolute;
    left: 12px;
    color: #5f6368;
    width: 16px;
    height: 16px;
}

.search-input-wrapper input {
    width: 100%;
    padding: 10px 12px 10px 36px;
    border: 1px solid #f1f3f4;
    background: #f1f3f4;
    border-radius: 8px;
    font-size: 13px;
    color: #202124;
    outline: none;
    transition: all 0.2s;
}

.search-input-wrapper input:focus {
    background: #fff;
    border-color: #1a73e8;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.inbox-scroll {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
}

.inbox-scroll::-webkit-scrollbar { width: 4px; }
.inbox-scroll::-webkit-scrollbar-thumb { background: #dadce0; border-radius: 4px; }

/* ── Message Row ── */
.msg-row {
    display: flex;
    align-items: flex-start;
    padding: 10px 14px;
    border-bottom: 1px solid #f1f3f4;
    cursor: pointer;
    transition: background 0.12s;
    gap: 10px;
}

.msg-row:hover { background: #f1f3f4; }
.msg-row.active { background: #e8f0fe !important; }
.msg-row.unread { background: #fff; }
.msg-row.read   { background: #f8f9fa; }

.unread-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #1a73e8;
    margin-top: 6px;
    flex-shrink: 0;
}

.read-space { width: 8px; flex-shrink: 0; }

.msg-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700;
    color: #fff;
    flex-shrink: 0;
    text-transform: uppercase;
}

.msg-content { flex: 1; min-width: 0; }

.msg-top {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 2px;
}

.msg-name {
    font-size: 13px;
    color: #202124;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 170px;
}

.msg-row.read .msg-name { font-weight: 400; color: #5f6368; }

.msg-time {
    font-size: 11px;
    color: #80868b;
    flex-shrink: 0;
    margin-left: 6px;
}

.msg-row.unread .msg-time { font-weight: 600; color: #202124; }

.msg-preview {
    font-size: 12px;
    color: #5f6368;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ── RIGHT PANEL ── */
.detail-pane {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #fff;
    overflow: hidden;
}

.detail-empty {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #80868b;
    gap: 12px;
}

.detail-empty p { font-size: 14px; margin: 0; }

.detail-content {
    display: none;
    flex-direction: column;
    height: 100%;
    overflow-y: auto;
}

.detail-content.visible { display: flex; }

.detail-topbar {
    padding: 16px 24px 12px;
    border-bottom: 1px solid #e8eaed;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.detail-subject {
    font-size: 20px;
    font-weight: 500;
    color: #202124;
    flex: 1;
}

.d-action-btn {
    width: 34px; height: 34px;
    border-radius: 50%;
    border: none;
    background: transparent;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #5f6368;
}
.d-action-btn:hover { background: #f1f3f4; }

.detail-sender {
    padding: 14px 24px;
    border-bottom: 1px solid #f1f3f4;
    display: flex;
    align-items: center;
    gap: 12px;
}

.sender-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 700;
    color: #fff;
}

.sender-info { flex: 1; min-width: 0; }
.sender-name { font-size: 14px; font-weight: 600; color: #202124; }
.sender-email { font-size: 12px; color: #5f6368; }
.sender-date { font-size: 12px; color: #80868b; }

.meta-chips {
    padding: 12px 24px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    border-bottom: 1px solid #f1f3f4;
}

.meta-chip {
    background: #f1f3f4;
    border-radius: 16px;
    padding: 4px 12px;
    font-size: 12px;
    color: #5f6368;
    display: flex;
    align-items: center;
    gap: 5px;
}

.meta-chip strong { color: #202124; font-weight: 500; text-transform: capitalize; }

.detail-body {
padding: 0 24px 24px 24px;    flex: 1;
    font-size: 15px;
    color: #202124;
    line-height: 1.75;
    white-space: pre-wrap;
    word-break: break-word;
}
.detail-sub {
    padding-left: 24px;
    margin: 12px 0 4px;
    font-weight: 500;
    line-height: 1.75;
    font-size: 16px;
    color: #202124;

  
}

/* Colors */
.av-0 { background: #1a73e8; }
.av-1 { background: #34a853; }
.av-2 { background: #ea4335; }
.av-3 { background: #9334e6; }
.av-4 { background: #00897b; }
.av-5 { background: #e37400; }

@media (max-width: 768px) {
    .gmail-wrap { flex-direction: column; height: auto; margin: 6px; }
    .inbox-list { width: 100%; border-right: none; border-bottom: 1px solid #e8eaed; max-height: 40vh; }
    .detail-pane { min-height: 50vh; }
}
</style>

<div class="gmail-wrap">

    {{-- ════ LEFT: Message List ════ --}}
    <div class="inbox-list">
        <div class="inbox-header">
            <h6>Inbox</h6>
            @php $unread = $contacts->where('is_read', false)->count(); @endphp
            @if($unread)
                <span class="badge-count" id="badgeCount">{{ $unread }} new</span>
            @endif
        </div>

        {{-- RADIO FILTER BUTTONS --}}
        <div class="inbox-filters">
            <label class="filter-chip">
                <input type="radio" name="filter_type" value="all" checked onchange="filterContacts()">
                All
            </label>
            <label class="filter-chip">
                <input type="radio" name="filter_type" value="landowner" onchange="filterContacts()">
                Landowner
            </label>
            <label class="filter-chip">
                <input type="radio" name="filter_type" value="customer" onchange="filterContacts()">
                Customer
            </label>
        </div>

        {{-- SEARCH BAR --}}
        <div class="inbox-search">
            <div class="search-input-wrapper">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 001.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 00-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 005.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" fill="currentColor"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Search by name, phone, message..." onkeyup="filterContacts()">
            </div>
        </div>

        <div class="inbox-scroll" id="inboxScroll">
            @forelse($contacts as $contact)
            @php
                $ci = $contact->id % 6;
                $initial = strtoupper(mb_substr($contact->name, 0, 1));
            @endphp
            <div class="msg-row {{ $contact->is_read ? 'read' : 'unread' }}"
                 id="row-{{ $contact->id }}"
                 onclick="openContact({{ $contact->id }})">

                @if(!$contact->is_read)
                    <div class="unread-dot" id="dot-{{ $contact->id }}"></div>
                @else
                    <div class="read-space"></div>
                @endif

                <div class="msg-avatar av-{{ $ci }}">{{ $initial }}</div>

                <div class="msg-content">
                    <div class="msg-top">
                        <span class="msg-name">{{ $contact->name }}</span>
                        <span class="msg-time">{{ $contact->created_at->format('M d') }}</span>
                    </div>
                    <div class="msg-preview">{{ Str::limit($contact->subject ?? $contact->message, 60) }}</div>
                </div>
            </div>
            @empty
            <div style="padding:40px 16px; text-align:center; color:#80868b; font-size:13px;">
                No messages found
            </div>
            @endforelse
        </div>
    </div>

    {{-- ════ RIGHT: Detail Pane ════ --}}
    <div class="detail-pane">
        {{-- Empty state --}}
        <div class="detail-empty" id="detailEmpty">
            <svg width="72" height="72" viewBox="0 0 24 24" fill="none">
                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="#cfd4d9"/>
            </svg>
            <p>Select a message to read</p>
        </div>

        {{-- Detail content --}}
        <div class="detail-content" id="detailContent">
            <div class="detail-topbar">
                <div class="detail-subject" id="dSubject">—</div>
                <div class="detail-actions">
                    <form id="deleteForm" method="POST" style="display:inline;" onsubmit="return confirm('Delete this message?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="d-action-btn" title="Delete">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" fill="#5f6368"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="detail-sender">
                <div class="sender-avatar" id="dAvatar">A</div>
                <div class="sender-info">
                    <div class="sender-name" id="dName">—</div>
                    <div class="sender-email" id="dEmail">—</div>
                </div>
                <div class="sender-date" id="dDate">—</div>
            </div>

            <div class="meta-chips">
                <div class="meta-chip">📞 <strong id="dPhone">—</strong></div>
                <div class="meta-chip" id="dTypeChip">🏷 <strong id="dType">—</strong></div>
                <div class="meta-chip" id="dLocalityChip" style="display:none;">📍 <strong id="dLocality">—</strong></div>
                <div class="meta-chip" id="dCategoryChip" style="display:none;">🏗 <strong id="dCategory">—</strong></div>
            </div>

            <div class="detail-sub" id="dSub">—</div>
            <div class="detail-body" id="dBody">—</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const CONTACTS = @json($contacts->keyBy('id')->toArray());
let currentId = null;

const avColors = ['#1a73e8','#34a853','#ea4335','#9334e6','#00897b','#e37400'];

// Combine Radio Button + Search Input filter
function filterContacts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const typeFilter = document.querySelector('input[name="filter_type"]:checked').value; // 'all', 'landowner', 'customer'
    
    document.querySelectorAll('.msg-row').forEach(row => {
        const id = row.getAttribute('id').replace('row-', '');
        const c = CONTACTS[id];
        if (!c) return;

        // 1. Check Type (Radio Button)
        let matchesType = true;
        if (typeFilter !== 'all') {
            const dbType = (c.type || '').toLowerCase();
            matchesType = dbType.includes(typeFilter); 
        }

        // 2. Check Search Term (Input box)
        const searchableText = [
            c.name || '', 
            c.email || '', 
            c.phone || '', 
            c.message || '', 
            c.locality || ''
        ].join(' ').toLowerCase();
        
        const matchesSearch = searchableText.includes(searchTerm);

        // Show/Hide Row
        if (matchesType && matchesSearch) {
            row.style.display = 'flex';
        } else {
            row.style.display = 'none';
        }
    });
}

function openContact(id) {
    const c = CONTACTS[id];
    if (!c) return;
    currentId = id;

    // Active row highlight
    document.querySelectorAll('.msg-row').forEach(r => r.classList.remove('active'));
    const row = document.getElementById('row-' + id);
    if (row) row.classList.add('active');

    // Fill detail pane
    const ci = id % 6;
    document.getElementById('dAvatar').textContent = c.name.charAt(0).toUpperCase();
    document.getElementById('dAvatar').style.background = avColors[ci];

    document.getElementById('dSubject').textContent = c.name;
    document.getElementById('dName').textContent    = c.name;
    document.getElementById('dEmail').textContent   = c.email || 'No email provided';
    document.getElementById('dPhone').textContent   = c.phone || 'No phone provided';
    document.getElementById('dType').textContent    = c.type || '—';
document.getElementById('dSub').textContent = c.subject
    ? 'Subject: ' + c.subject
    : '';    document.getElementById('dBody').textContent    = c.message || '';

    const d = new Date(c.created_at);
    document.getElementById('dDate').textContent = d.toLocaleString('en-BD', {
        dateStyle: 'medium', timeStyle: 'short'
    });

    if (c.locality) {
        document.getElementById('dLocality').textContent = c.locality;
        document.getElementById('dLocalityChip').style.display = 'flex';
    } else {
        document.getElementById('dLocalityChip').style.display = 'none';
    }

    if (c.land_category) {
        document.getElementById('dCategory').textContent = c.land_category;
        document.getElementById('dCategoryChip').style.display = 'flex';
    } else {
        document.getElementById('dCategoryChip').style.display = 'none';
    }

    // Set delete action
    document.getElementById('deleteForm').action = `/contacts/${id}`; 

    // Show Detail pane
    document.getElementById('detailEmpty').style.display   = 'none';
    document.getElementById('detailContent').classList.add('visible');

    // Auto mark as read ONLY IF unread
    if (!c.is_read) {
        markRead(id);
    }
}

function markRead(id) {
    fetch(`/contacts/${id}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest', 
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            CONTACTS[id].is_read = true;
            
            // Update row UI
            const row = document.getElementById('row-' + id);
            if (row) {
                row.classList.remove('unread');
                row.classList.add('read');
            }
            
            // Remove Unread Dot
            const dot = document.getElementById('dot-' + id);
            if (dot) dot.remove();

            // Replace Unread Dot with empty space
            const readSpace = document.createElement('div');
            readSpace.className = 'read-space';
            if(row) row.insertBefore(readSpace, row.firstChild);

            // Update Badge count
            const badge = document.getElementById('badgeCount');
            if (badge) {
                const cur = parseInt(badge.textContent) - 1;
                if (cur <= 0) badge.remove();
                else badge.textContent = cur + ' new';
            }
        }
    })
    .catch(error => console.error("Error updating read status:", error));
}
</script>
@endpush

@endsection