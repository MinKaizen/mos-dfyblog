<?php

namespace Data443\gdpr\framework\Illuminate\Contracts\Console;

interface Application
{
    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @param  \Symfony\Component\Console\Output\OutputInterface|null  $outputBuffer
     * @return int
     */
    public function call($command, array $parameters = [], $outputBuffer = null);
    /**
     * Get the output from the last command.
     *
     * @return string
     */
    public function output();
}
