<div class="p-4 sm:p-6 bg-slate-50 dark:bg-gray-900 min-h-[calc(100vh-5rem)] flex flex-col justify-between">
    <!-- Header -->
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-xl text-white shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    AI Assistant Bot
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                        Laravel AI SDK
                    </span>
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ask questions, analyze assessments, or generate insights.</p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <!-- Model Selection -->
            <select wire:model.live="selectedModel" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-purple-500 focus:border-purple-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                <option value="llama3.2:1b">Ollama (Llama 3.2 1B - Lightweight)</option>
                <option value="llama3.2">Ollama (Llama 3.2)</option>
                <option value="glm-5.2:cloud">Ollama (GLM 5.2 Cloud)</option>
                <option value="glm-5.2">Ollama (GLM 5.2 Local)</option>
                <option value="llama3">Ollama (Llama 3)</option>
                <option value="gemma4">Ollama (Gemma 4)</option>
                <option value="claude-3-5-sonnet-20241022">Claude 3.5 Sonnet</option>
                <option value="claude-3-5-haiku-20241022">Claude 3.5 Haiku</option>
                <option value="gemini-2.0-flash">Gemini 2.0 Flash</option>
                <option value="gemini-2.5-flash">Gemini 2.5 Flash</option>
                <option value="gpt-4o">GPT-4o</option>
            </select>

            <!-- Clear Chat -->
            <button wire:click="clearChat" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition" title="Clear Chat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Chat Messages Window -->
    <div class="flex-1 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 sm:p-6 overflow-y-auto max-h-[580px] space-y-4 mb-4" id="chat-window">
        @foreach($messages as $msg)
            @if($msg['role'] === 'assistant')
                <div class="flex items-start gap-3 max-w-3xl">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow">
                        AI
                    </div>
                    <div class="flex flex-col">
                        <div class="p-4 rounded-2xl rounded-tl-none {{ isset($msg['is_error']) ? 'bg-red-50 text-red-800 border border-red-200 dark:bg-red-950 dark:text-red-300 dark:border-red-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100' }} shadow-sm text-sm leading-relaxed whitespace-pre-wrap">
                            {{ $msg['content'] }}
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1 ml-1">{{ $msg['time'] ?? '' }}</span>
                    </div>
                </div>
            @else
                <div class="flex items-start justify-end gap-3 ml-auto max-w-3xl">
                    <div class="flex flex-col items-end">
                        <div class="p-4 rounded-2xl rounded-tr-none bg-purple-600 text-white shadow-sm text-sm leading-relaxed whitespace-pre-wrap">
                            {{ $msg['content'] }}
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1 mr-1">{{ $msg['time'] ?? '' }}</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 flex items-center justify-center font-bold text-xs shrink-0 shadow">
                        ME
                    </div>
                </div>
            @endif
        @endforeach

        <div wire:loading wire:target="sendMessage" class="flex items-start gap-3 max-w-3xl">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow animate-pulse">
                AI
            </div>
            <div class="p-4 rounded-2xl rounded-tl-none bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-sm flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                AI is thinking...
            </div>
        </div>
    </div>

    <!-- Quick Suggested Prompts -->
    <div class="mb-3 flex flex-wrap gap-2">
        <button wire:click="selectSuggestedPrompt('How do I summarize product assessments?')" class="text-xs px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-purple-50 hover:text-purple-600 hover:border-purple-300 transition">
            💡 How to summarize assessments?
        </button>
        <button wire:click="selectSuggestedPrompt('Help me write a customer product report.')" class="text-xs px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-purple-50 hover:text-purple-600 hover:border-purple-300 transition">
            📝 Write customer product report
        </button>
        <button wire:click="selectSuggestedPrompt('Explain CBC, LITE, and CBB product categories.')" class="text-xs px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-purple-50 hover:text-purple-600 hover:border-purple-300 transition">
            🔍 Explain product categories
        </button>
    </div>

    <!-- Input Form -->
    <form wire:submit.prevent="sendMessage" class="flex gap-2">
        <div class="relative w-full">
            <input 
                type="text" 
                wire:model="prompt" 
                placeholder="Ask AI anything..." 
                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block w-full p-3.5 pr-12 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white shadow-sm"
                required
            />
        </div>
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            class="px-5 py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-xl text-sm transition shadow-md flex items-center justify-center shrink-0 disabled:opacity-50"
        >
            <svg class="w-5 h-5 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
        </button>
    </form>
</div>
