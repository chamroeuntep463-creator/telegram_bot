<div class="p-6 bg-slate-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-sky-500/10 text-sky-500 flex items-center justify-center">
                        <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                            <path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.56 8.16l-2.02 9.51c-.15.68-.55.84-1.12.52l-3.1-2.29-1.5 1.44c-.17.17-.31.31-.63.31l.22-3.17 5.77-5.21c.25-.22-.05-.34-.39-.12l-7.14 4.49-3.07-.96c-.67-.21-.68-.67.14-.99l12.01-4.63c.56-.2 1.05.14.83.91z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Telegram Bot Integration</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Connect your Telegram Bot to send alerts, notifications, and updates</p>
                    </div>
                </div>

                <button wire:click="testConnection" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                    <svg wire:loading.remove wire:target="testConnection" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <svg wire:loading wire:target="testConnection" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Test Bot Connection</span>
                </button>
            </div>

            <!-- Status Alert -->
            @if ($statusMessage)
                <div class="mt-4 p-4 rounded-lg text-sm font-medium flex items-center gap-3
                    @if ($statusType === 'success') bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800
                    @elseif ($statusType === 'danger') bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800
                    @else bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 @endif">
                    <span>{{ $statusMessage }}</span>
                </div>
            @endif
        </div>

        <!-- Bot Information Card (If connected) -->
        @if ($botInfo)
            <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-5 dark:bg-emerald-900/20">
                <h3 class="text-sm font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-3">Bot Details Connected</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400 block text-xs">Bot Name</span>
                        <span class="font-bold text-gray-800 dark:text-white">{{ $botInfo['first_name'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400 block text-xs">Username</span>
                        <span class="font-bold text-sky-600 dark:text-sky-400">@ {{ $botInfo['username'] ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400 block text-xs">Bot ID</span>
                        <span class="font-mono text-gray-700 dark:text-gray-300">{{ $botInfo['id'] ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Bot Credentials Config -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Bot Credentials
                </h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Telegram Bot Token (<code class="text-xs text-purple-600 dark:text-purple-400">TELEGRAM_BOT_TOKEN</code>)
                    </label>
                    <input type="password" wire:model.defer="botToken" placeholder="123456789:ABCdefGHIjklMNOpqrsTUVwxyZ" class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-sky-500 focus:border-sky-500">
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Created via <a href="https://t.me/BotFather" target="_blank" class="text-sky-600 hover:underline">@BotFather</a> on Telegram</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Default Chat ID (<code class="text-xs text-purple-600 dark:text-purple-400">TELEGRAM_CHAT_ID</code>)
                    </label>
                    <input type="text" wire:model="chatId" placeholder="e.g. 123456789 or -100123456789" class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-sky-500 focus:border-sky-500">
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">User Chat ID, Group ID, or Supergroup ID (starts with <code class="text-purple-600 dark:text-purple-400 font-mono">-100...</code>)</span>
                </div>
            </div>

            <!-- Send Test Message Form -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Send Telegram Message
                </h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Chat ID</label>
                    <input type="text" wire:model="chatId" placeholder="Target Chat ID" class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-sky-500 focus:border-sky-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message Content (HTML supported)</label>
                    <textarea wire:model="messageText" rows="3" placeholder="Hello from Laravel! 🚀" class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-sky-500 focus:border-sky-500"></textarea>
                </div>

                <button wire:click="sendMessage" wire:loading.attr="disabled" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow transition flex items-center justify-center gap-2">
                    <svg wire:loading.remove wire:target="sendMessage" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                    <svg wire:loading wire:target="sendMessage" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Send Message Now</span>
                </button>
            </div>
        </div>

        <!-- How to get Telegram Bot & Chat ID Guide -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    How to Connect Your Telegram Bot
                </h2>
                <button wire:click="fetchUpdates" class="text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-3 py-1.5 rounded-lg text-gray-700 dark:text-gray-200 transition">
                    Fetch Recent Updates (Find Chat ID)
                </button>
            </div>

            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600 dark:text-gray-300">
                <li>Open Telegram and search for <strong class="text-sky-600">@BotFather</strong>.</li>
                <li>Send command <code class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-purple-600 dark:text-purple-400">/newbot</code> and follow instructions to get your <strong>Bot API Token</strong>.</li>
                <li>Copy the API Token into the field above or set <code class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-purple-600 dark:text-purple-400">TELEGRAM_BOT_TOKEN</code> in your <code class="text-emerald-600">.env</code> file.</li>
                <li>Send a message to your new bot on Telegram, then click <strong>"Fetch Recent Updates"</strong> to view your Chat ID!</li>
            </ol>

            <!-- Display Updates -->
            @if ($updates)
                <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Recent Telegram Messages & Chat IDs</h4>
                    <div class="space-y-2 max-h-48 overflow-y-auto font-mono text-xs">
                        @foreach ($updates as $up)
                            @if (isset($up['message']))
                                <div class="p-2 bg-white dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                    <div>
                                        <span class="font-bold text-sky-600">Chat ID: {{ $up['message']['chat']['id'] ?? 'Unknown' }}</span>
                                        <span class="text-gray-500">({{ $up['message']['from']['first_name'] ?? '' }})</span>
                                        <div class="text-gray-800 dark:text-gray-200 mt-1">"{{ $up['message']['text'] ?? '' }}"</div>
                                    </div>
                                    <button wire:click="$set('chatId', '{{ $up['message']['chat']['id'] ?? '' }}')" class="px-2 py-1 bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-300 rounded hover:bg-sky-200">
                                        Use Chat ID
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
