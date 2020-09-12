<?php

    namespace App\Console\Commands;

    use App\Models\Ads;
    use Illuminate\Console\Command;

    class ShowAllAds extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'ads-show-all';

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
            $ads = Ads::select(['*'])->orderBy('created_at', 'desc')->get();
            foreach ($ads as $item) {
                $this->info("id: " . $item->id);
                $this->line("title " . $item->title);
                $this->line("description: " . $item->description);
                $this->question('------------------------------------');
                $images = $item->images()->get();
                if (!empty($images)) {
                    $this->line("images: ");
                    $counter=0;
                    foreach ($images as $image) {
                        $counter++;
                        $this->line($counter.". " . $image->url);
                    }
                }
            }
            return 0;
        }
    }
