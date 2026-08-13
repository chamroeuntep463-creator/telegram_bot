<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Ai\Ai;
use function Laravel\Ai\agent;
use Throwable;

class TestAiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:test {--model=claude-haiku-4-5-20251001 : The model to test} {--prompt=Hello! : Test prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Laravel AI SDK connection with current provider and credentials';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Testing Laravel AI SDK Connection...');
        $this->line('Provider: ' . config('ai.default'));
        $this->line('Endpoint URL: ' . (config('ai.providers.anthropic.url') ?? 'Default'));
        $this->line('Model: ' . $this->option('model'));
        $this->newLine();

        try {
            $response = agent('Respond succinctly in 1-2 sentences.')
                ->prompt($this->option('prompt'), model: $this->option('model'));

            $this->info('SUCCESS! AI Response:');
            $this->comment($response->text);

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('FAILED! Exception encountered:');
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
