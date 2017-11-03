<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Maatwebsite\Excel\Collections\RowCollection;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class MembershipCommand extends Command
{
    /**
     * The name and signature of the command.
     *
     * @var string
     */
    protected $signature = 'run {filename} {folder?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'The membership app command';

    /**
     * Execute the command. Here goes the code.
     *
     * @return void
     */
    public function handle(): void
    {
        if(empty($filename = $this->argument('filename')) || !file_exists($filename)) {
            $this->error('le fichier ' . $filename . ' n\'existe pas.');
     return;		
        }

        /** @var RowCollection $data */
        $data = app('excel')->load($filename)->get();

        $bar = $this->output->createProgressBar($data->count());

        foreach ($data->toArray() as $member) {
	    $text = $member['prenom'] . ' ' . $member['nom'] . ' ' . $member['cin'];
            app('qrcode')->format('png')->size(100)->generate($text, 'output/'.$text.'.png');
            $bar->advance();
        }

        $bar->finish();
    }
}
