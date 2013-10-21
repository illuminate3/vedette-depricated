<?php namespace Illuminate3\Vedette;

class Vedette {

    /**
     * Added checkpoints.
     *
     * @var array
     */
    protected $checkpoints = array();

    /**
     * Add a new checkpoint.
     *
     * @return void
     */
    public function addCheckpoint()
    {
        $checkpointTime = microtime(true);

        // Grab a debug backtrace array so we can use the line and file name being used to add
        // a checkpoint.
        $trace = debug_backtrace();

        // Build the variables to be used in our checkpoint message.
        $number = count($this->checkpoints) + 1;

        $line = $trace[0]['line'];

        $file = $trace[0]['file'];

        $executionTime = round($checkpointTime - $this->getStartTime(), 4);

        $this->checkpoints[] = compact('number', 'line', 'file', 'executionTime');
    }

    /**
     * Get the checkpoints.
     *
     * @return array
     */
    public function getCheckpoints()
    {
        return $this->checkpoints;
    }

    /**
     * Get the start time.
     *
     * @return int
     */
    protected function getStartTime()
    {
        if (defined('LARAVEL_START'))
        {
            return LARAVEL_START;
        }

        return microtime(true);
    }

}