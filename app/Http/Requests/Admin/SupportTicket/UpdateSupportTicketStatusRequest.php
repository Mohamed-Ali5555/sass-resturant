<?php

namespace App\Http\Requests\Admin\SupportTicket;

use App\Models\SupportTicket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupportTicketStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var SupportTicket $support_ticket */
        $ticket = $this->route('support_ticket');

        return $this->user()->can('update', $ticket);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::in(['open', 'pending', 'resolved', 'closed'])],
            'priority' => ['sometimes', 'nullable', 'string', Rule::in(['low', 'normal', 'high', 'urgent'])],
        ];
    }
}
