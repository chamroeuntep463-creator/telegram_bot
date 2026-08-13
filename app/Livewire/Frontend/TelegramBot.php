<?php

namespace App\Livewire\Frontend;

use App\Services\TelegramService;
use Livewire\Component;
use Exception;

class TelegramBot extends Component
{
    public string $botToken = '';
    public string $chatId = '';
    public string $messageText = '';

    public ?array $botInfo = null;
    public array $updates = [];

    public string $statusMessage = '';
    public string $statusType = ''; // 'success' | 'danger' | 'info'

    public function mount()
    {
        $this->botToken = config('services.telegram.bot_token') ?? '';
        $this->chatId = config('services.telegram.chat_id') ?? '';
    }

    public function testConnection()
    {
        $this->resetStatus();

        if (empty(trim($this->botToken))) {
            $this->setStatus('Please enter a valid Telegram Bot Token.', 'danger');
            return;
        }

        try {
            $service = new TelegramService(trim($this->botToken));
            $this->botInfo = $service->getBotInfo();

            $botUsername = $this->botInfo['username'] ?? 'Unknown';
            $this->setStatus("Successfully connected to Telegram Bot (@{$botUsername})!", 'success');
        } catch (Exception $e) {
            $this->botInfo = null;
            $this->setStatus("Connection Error: " . $e->getMessage(), 'danger');
        }
    }

    public function sendMessage()
    {
        $this->resetStatus();

        $token = trim($this->botToken);
        $chat = trim($this->chatId);
        $msg = trim($this->messageText);

        if (empty($token)) {
            $this->setStatus('Telegram Bot Token is required.', 'danger');
            return;
        }

        if (empty($chat)) {
            $this->setStatus('Telegram Chat ID is required.', 'danger');
            return;
        }

        if (empty($msg)) {
            $this->setStatus('Please enter a message to send.', 'danger');
            return;
        }

        try {
            $service = new TelegramService($token);
            $response = $service->sendMessage($chat, $msg);

            $this->messageText = '';

            if (!empty($response['migrated_to_chat_id'])) {
                $newChatId = $response['migrated_to_chat_id'];
                $this->chatId = $newChatId;
                $this->setStatus("Message sent! Your group chat was upgraded to a Supergroup. Chat ID updated to: {$newChatId}", 'success');
            } else {
                $this->setStatus("Message sent successfully to Chat ID: {$chat}!", 'success');
            }
        } catch (Exception $e) {
            $this->setStatus("Failed to send message: " . $e->getMessage(), 'danger');
        }
    }

    public function fetchUpdates()
    {
        $this->resetStatus();

        $token = trim($this->botToken);
        if (empty($token)) {
            $this->setStatus('Telegram Bot Token is required to fetch updates.', 'danger');
            return;
        }

        try {
            $service = new TelegramService($token);
            $this->updates = $service->getUpdates();

            if (empty($this->updates)) {
                $this->setStatus("No recent updates found. Send a message to your bot on Telegram first, then try again.", 'info');
            } else {
                $count = count($this->updates);
                $this->setStatus("Found {$count} update(s) from Telegram.", 'success');
            }
        } catch (Exception $e) {
            $this->setStatus("Error fetching updates: " . $e->getMessage(), 'danger');
        }
    }

    protected function setStatus(string $message, string $type = 'info')
    {
        $this->statusMessage = $message;
        $this->statusType = $type;
    }

    protected function resetStatus()
    {
        $this->statusMessage = '';
        $this->statusType = '';
    }

    public function render()
    {
        return view('livewire.frontend.telegram-bot')
            ->layout('backend.app');
    }
}
