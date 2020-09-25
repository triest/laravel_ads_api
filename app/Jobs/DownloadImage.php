<?php

    namespace App\Jobs;

    use App\Models\Image;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Storage;
    use Symfony\Component\Filesystem\Exception\IOException;

    class DownloadImage implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        public $id;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct($id)
        {
            $this->id = $id;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            if ($this->attempts() > 10) {
                //
            }

            //
            $image = Image::select(['*'])->where('id', $this->id)->first();
            if ($image == null || $image->url == null) {
                $delayInSeconds = 5 * 60;
                $this->release($delayInSeconds);
            }
            try {
                $contents = file_get_contents($image->url);
            } catch (IOException $exception) {
                $delayInSeconds = 5 * 60;
                $this->release($delayInSeconds);
            }
            $name = uniqid() . ".png";
            $image->name = $name;
            $patch = "public/" . $name;
            Storage::put($patch, $contents);
            $image->downloaded = 1;
            $image->save();

        }
    }
