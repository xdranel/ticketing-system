<?php

namespace App\Http\Requests;

use App\Enums\TicketCategory;
use App\Enums\TicketPriority;
use App\Enums\UserRole;
use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Ticket::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isAdmin = $this->user()?->hasRole(UserRole::Admin);

        return [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', Rule::enum(TicketCategory::class)],
            'priority' => ['required', Rule::enum(TicketPriority::class)],
            'customer_id' => $isAdmin
                ? ['required', Rule::exists('users', 'id')->where('role', UserRole::Customer->value)]
                : ['prohibited'],
            'attachments.*' => [
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,rar,7z',
            ]
        ];
    }
}
