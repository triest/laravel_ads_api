<?php
    /**
     * Created by PhpStorm.
     * User: triest
     * Date: 13.09.2020
     * Time: 1:18
     */

    namespace App\Builders;


    use App\Jobs\DownloadImage;
    use App\Models\Ads;
    use App\Models\Image;

    class AdsBuilder
    {
        private $title;
        private $description;
        private $price;
        private $images;

        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description): void
        {
            $this->description = $description;
        }

        /**
         * @param mixed $price
         */
        public function setPrice($price): void
        {
            $this->price = $price;
        }

        public function addImage($image)
        {
            $this->images[] = $image;
        }

        public function addImages(Array $images)
        {
            $this->images = $images;
        }


        public function getResult()
        {
            $ads = new Ads();
            $ads->title = $this->title;
            $ads->description = $this->description;
            $ads->price = $this->price;
            $ads->save();

            if (!empty($this->images)) {
                foreach ($this->images as $key) {
                    $image = new Image();
                    $image->url = $key;
                    $image->save();
                    $ads->images()->save($image);
                    DownloadImage::dispatchAfterResponse($image->id);
                }
            }

            return $ads;
        }


    }