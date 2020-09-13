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
            //
            $image = Image::select(['*'])->where('id', $this->id)->first();
            if ($image == null || $image->url == null) {
                return;
            }
            try {
                $contents = file_get_contents($image->url);
            } catch (IOException $exception) {
                return;
            }
            $name = uniqid() . ".png";
            $image->name = $name;
            $patch = "public/" . $name;
            Storage::put($patch, $contents);
            $image->downloaded = 1;
            $image->save();

        }
    }
