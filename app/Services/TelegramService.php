<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class TelegramService
{
    protected string $botToken;

    public function __construct(?string $botToken = null)
    {
        $this->botToken = $botToken ?? config('services.telegram.bot_token', '');
    }

    protected function baseUrl(): string
    {
        return "https://api.telegram.org/bot{$this->botToken}";
    }

    /**
     * Get information about the bot.
     */
    public function getBotInfo(): array
    {
        if (empty($this->botToken)) {
            throw new Exception("Telegram Bot Token is missing. Please set TELEGRAM_BOT_TOKEN in your .env file or form.");
        }

        $response = Http::get("{$this->baseUrl()}/getMe");

        if ($response->failed()) {
            $desc = $response->json('description') ?? $response->body();
            throw new Exception("Telegram API error: {$desc}");
        }

        return $response->json('result', []);
    }

    /**
     * Send a text message to a specific Telegram Chat ID.
     * Automatically handles supergroup migration (migrate_to_chat_id).
     */
    public function sendMessage(string $chatId, string $message, string $parseMode = 'HTML'): array
    {
        if (empty($this->botToken)) {
            throw new Exception("Telegram Bot Token is missing. Please set TELEGRAM_BOT_TOKEN in your .env file or form.");
        }

        if (empty($chatId)) {
            throw new Exception("Telegram Chat ID is missing. Please provide a valid Chat ID.");
        }

        $response = Http::post("{$this->baseUrl()}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => $parseMode,
        ]);

        if ($response->failed()) {
            $migrateToChatId = $response->json('parameters.migrate_to_chat_id');
            
            if ($migrateToChatId) {
                // Retry sending to the new supergroup Chat ID automatically
                $retryResponse = Http::post("{$this->baseUrl()}/sendMessage", [
                    'chat_id' => $migrateToChatId,
                    'text' => $message,
                    'parse_mode' => $parseMode,
                ]);

                if ($retryResponse->successful()) {
                    return [
                        'result' => $retryResponse->json('result', []),
                        'migrated_to_chat_id' => (string) $migrateToChatId,
                    ];
                }
            }

            $desc = $response->json('description') ?? $response->body();
            
            if ($migrateToChatId) {
                $desc .= " (New Supergroup Chat ID: {$migrateToChatId})";
            }

            throw new Exception("Telegram API error: {$desc}");
        }

        return [
            'result' => $response->json('result', []),
            'migrated_to_chat_id' => null,
        ];
    }

    /**
     * Get recent updates / messages sent to the bot.
     */
    public function getUpdates(): array
    {
        if (empty($this->botToken)) {
            throw new Exception("Telegram Bot Token is missing. Please set TELEGRAM_BOT_TOKEN in your .env file or form.");
        }

        $response = Http::get("{$this->baseUrl()}/getUpdates");

        if ($response->failed()) {
            $desc = $response->json('description') ?? $response->body();
            throw new Exception("Telegram API error: {$desc}");
        }

        return $response->json('result', []);
    }
}
