<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketAttachment>
 */
class TicketAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        Storage::fake('attachments');

//        $file = UploadedFile::fake()->image('attachment.jpg', 800, 600);
//        $file = UploadedFile::fake()->create('attachment.jpg', 800, 'image/jpeg');
//        $file = UploadedFile::fake()->create('document.pdf', 800, 'application/pdf');
        $file = UploadedFile::fake()->image(
            fake()->word() . '.jpg',
            800,
            600
        );

        $path = $file->store('ticket-attachments-dummy', 'attachments');

        return [
            'ticket_id' => Ticket::factory(),
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];
    }
}
