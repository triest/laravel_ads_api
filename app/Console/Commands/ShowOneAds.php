<?php

namespace App\Console\Commands;

use App\Models\Ads;
use Illuminate\Console\Command;

class ShowOneAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads-show {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id=$this->argument('id');
        if(!intval($id)){
            $this->error("Id must be integer");
            return 0;
        }
        $item=Ads::select('*')->where(['id' => $id])->first();
        if($item==null){
            $this->info("ads not found");
            return 0;
        }
        $this->info("id: " . $item->id);
        $this->line("title " . $item->title);
        $this->line("description: " . $item->description);
        $this->question('------------------------------------');
        $images = $item->images()->get();
        if (!empty($images)) {
            $counter=0;
            foreach ($images as $image) {
                $counter++;
                $this->line($counter.". " . $image->url);
            }
        }

        return 0;
    }
}
