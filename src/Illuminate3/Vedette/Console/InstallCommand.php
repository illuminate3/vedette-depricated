<?php namespace Illuminate3\Vedette\Console;

//
// @author Steve Montambeault
// @link   http://stevemo.ca
//

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {

    /**
    * The console command name.
    *
    * @var string
    */
    protected $name = 'vedette:install';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'publish assets,configs and run migration';

    /**
     * Exceute the console command
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function fire()
    {
        $this->call('migrate', array('--env' => $this->option('env'), '--package' => 'cartalyst/sentry' ) );
        $this->call('migrate', array('--env' => $this->option('env'), '--package' => 'illuminate3/vedette' ) );
        $this->call('config:publish', array('package' => 'cartalyst/sentry' ) );
        $this->call('config:publish', array('package' => 'anahkiasen/former' ) );
        $this->call('config:publish', array('package' => 'illuminate3/vedette' ) );
        $this->call('asset:publish', array('package' => 'illuminate3/vedette' ) );

        if ($this->confirm('Do you wish to create a user? [yes|no]'))
        {
            $this->call('vedette:user');
        }
    }


    public function getOptions()
    {
        return array(
            array('env', null, InputOption::VALUE_OPTIONAL, 'The environment the command should run under.', null),
        );
    }
}
