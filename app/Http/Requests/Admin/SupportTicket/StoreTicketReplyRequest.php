<?php

namespace App\Http\Requests\Admin\SupportTicket;

use App\Models\SupportTicket;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var SupportTicket $support_ticket */
        $ticket = $this->route('support_ticket');

        return $this->user()->can('reply', $ticket);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'max:10000'],
        ];
    }
}
