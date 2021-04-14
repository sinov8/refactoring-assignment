<?php

class ExtractionTest1
{
    /**
     * A) How can this function be improved by using the principle of extraction?
     */
    public function setCodeExamples(string $exampleBefore, string $exampleAfter)
    {
        $this->exampleBefore = file_get_contents(base_path("$exampleBefore.md"));
        $this->exampleAfter = file_get_contents(base_path("$exampleAfter.md"));
    }

}


class ExtractionTest2
{

    /**
     * How can this function be improved by using the principle of extraction?
     */
    public function setCodeExamples(string $exampleBefore, string $exampleAfter)
    {
        return User::whereNotNull('subscribed')->where('status', 'active');
    }

}


class ExtractionTest3
{

    /**
     * How can this handle function be improved by using the principle of extraction?
     */
    protected function handle()
    {
        $url = $this->option('url') ?: $this->ask('Please provide the URL for the import:');

        $importResponse = $this->http->get($url);

        $bar = $this->output->createProgressBar($importResponse->count());
        $bar->start();

        $this->userRepository->truncate();
        collect($importResponse->results)->each(function (array $attributes) use ($bar) {
            $this->userRepository->create($attributes);
            $bar->advance();
        });

        $bar->finish();
        $this->output->newLine();

        $this->info('Thanks. Users have been imported.');

        if ($this->option('with-backup')) {
            $this->storage
                ->disk('backups')
                ->put(date('Y-m-d') . '-import.json', $response->body());

            $this->info('Backup was stored successfully.');
        }

    }
}
