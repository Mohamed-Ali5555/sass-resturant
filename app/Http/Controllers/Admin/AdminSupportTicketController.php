<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupportTicket\StoreTicketReplyRequest;
use App\Http\Requests\Admin\SupportTicket\UpdateSupportTicketStatusRequest;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSupportTicketController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', SupportTicket::class);

        $status = $request->query('status', 'all');
        $query = SupportTicket::query()->with(['user', 'restaurant'])->orderByDesc('id');

        if (in_array($status, ['open', 'pending', 'resolved', 'closed'], true)) {
            $query->where('status', $status);
        }

        $tickets = $query->paginate(25)->withQueryString();

        return view('admin.support-tickets.index', compact('tickets', 'status'));
    }

    public function show(SupportTicket $support_ticket): View
    {
        $this->authorize('view', $support_ticket);

        $support_ticket->load(['messages.user', 'user', 'restaurant']);

        return view('admin.support-tickets.show', ['ticket' => $support_ticket]);
    }

    public function updateStatus(UpdateSupportTicketStatusRequest $request, SupportTicket $support_ticket): RedirectResponse
    {
        $support_ticket->update($request->only(['status', 'priority']));

        return redirect()
            ->route('admin.support-tickets.show', $support_ticket)
            ->with('status', __('Ticket updated.'));
    }

    public function reply(StoreTicketReplyRequest $request, SupportTicket $support_ticket): RedirectResponse
    {
        TicketMessage::query()->create([
            'ticket_id' => $support_ticket->getKey(),
            'user_id' => $request->user()->getKey(),
            'body' => $request->validated('body'),
            'is_staff_reply' => true,
        ]);

        if (in_array($support_ticket->status, ['resolved', 'closed'], true) === false) {
            $support_ticket->update(['status' => 'pending']);
        }

        return redirect()
            ->route('admin.support-tickets.show', $support_ticket)
            ->with('status', __('Reply posted.'));
    }
}
