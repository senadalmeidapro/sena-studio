<?php

namespace App\Support;

use App\Models\ContactMessage;

class ContactMessageReplyDraft
{
    public function for(ContactMessage $message): string
    {
        $template = match ($message->status) {
            ContactMessage::STATUS_NEW => 'leads.reply_draft.first_reply',
            ContactMessage::STATUS_PROPOSAL => 'leads.reply_draft.proposal_sent',
            default => 'leads.reply_draft.follow_up',
        };

        return __($template, [
            'name' => $message->name,
            'subject' => $message->subject,
        ]);
    }
}
