<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Laravel\Ai\Ai;
use Exception;

class AiBot extends Component
{
    public string $prompt = '';
    public array $messages = [];
    public string $selectedModel = 'llama3.2:1b';

    public function mount()
    {
        // Default initial greeting message
        $this->messages[] = [
            'role' => 'assistant',
            'content' => 'Hello! I am your AI Assistant. How can I help you today with your product assessment or questions?',
            'time' => now()->format('H:i')
        ];
    }

    protected function getProviderForModel(string $model): string
    {
        if (str_contains($model, 'claude')) {
            return 'anthropic';
        }
        if (str_contains($model, 'gpt') || str_contains($model, 'o1') || str_contains($model, 'o3')) {
            return 'openai';
        }
        if (str_contains($model, 'gemini')) {
            return 'gemini';
        }
        if (str_contains($model, 'gemma') || str_contains($model, 'llama') || str_contains($model, 'glm') || str_contains($model, 'mistral') || str_starts_with($model, 'ollama')) {
            return 'ollama';
        }
        return config('ai.default', 'ollama');
    }

    public function sendMessage()
    {
        $input = trim($this->prompt);
        if (empty($input)) {
            return;
        }

        // Push user message
        $this->messages[] = [
            'role' => 'user',
            'content' => $input,
            'time' => now()->format('H:i')
        ];

        $this->prompt = '';

        try {
            $provider = $this->getProviderForModel($this->selectedModel);

            // Call Laravel AI SDK via agent()
            $response = \Laravel\Ai\agent('You are a helpful AI assistant for a product assessment application. Answer concisely and accurately.')
                ->prompt($input, provider: $provider, model: $this->selectedModel);

            $reply = $response->text ?? 'No response text generated.';

            $this->messages[] = [
                'role' => 'assistant',
                'content' => $reply,
                'time' => now()->format('H:i')
            ];
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();

            if (str_contains($errorMsg, 'Failed to connect') || str_contains($errorMsg, 'cURL error 7') || str_contains($errorMsg, '11434')) {
                $errorMsg = "Could not connect to local Ollama server at http://localhost:11434.\n\n" .
                            "• Please start Ollama by running 'ollama serve' in your terminal or opening Ollama.\n" .
                            "• Alternatively, select a cloud AI model (Gemini or Claude) from the model dropdown above.";
            } elseif (str_contains($errorMsg, 'terminated') || str_contains($errorMsg, '0xc0000005')) {
                $errorMsg = "Local Ollama server process crashed while running '" . $this->selectedModel . "' (Access Violation / Memory Limit).\n\n" .
                            "• Try using a smaller model like 'llama3.2:1b' by running:  ollama pull llama3.2:1b\n" .
                            "• Or select a cloud AI model (Gemini or Claude) from the model dropdown above.";
            } elseif (str_contains($errorMsg, 'subscription') || str_contains($errorMsg, 'upgrade for access')) {
                $errorMsg = "Model '" . $this->selectedModel . "' requires an active Ollama cloud subscription.\n\n" .
                            "• Please visit https://ollama.com/upgrade to sign in or upgrade your account.\n" .
                            "• Or pull a free local model like 'llama3' by running:  ollama pull llama3";
            } elseif (str_contains($errorMsg, 'Unauthorized') || str_contains($errorMsg, '401')) {
                $errorMsg = "Ollama Cloud API returned Unauthorized (401).\n\n" .
                            "• Make sure OLLAMA_API_KEY is set in your .env file.\n" .
                            "• Or switch OLLAMA_HOST back to http://localhost:11434 for local usage.";
            } elseif (str_contains($errorMsg, 'not found')) {
                $errorMsg = "Model '" . $this->selectedModel . "' was not found in your local Ollama server.\n\n" .
                            "• Download it by running:  ollama pull " . $this->selectedModel . "\n" .
                            "• Or select another available model from the dropdown.";
            }

            $this->messages[] = [
                'role' => 'assistant',
                'content' => $errorMsg,
                'is_error' => true,
                'time' => now()->format('H:i')
            ];
        }
    }

    public function selectSuggestedPrompt(string $suggestedText)
    {
        $this->prompt = $suggestedText;
        $this->sendMessage();
    }

    public function clearChat()
    {
        $this->messages = [];
        $this->messages[] = [
            'role' => 'assistant',
            'content' => 'Chat cleared. How else can I assist you?',
            'time' => now()->format('H:i')
        ];
    }

    public function render()
    {
        return view('livewire.frontend.ai-bot')->layout('backend.app');
    }
}
