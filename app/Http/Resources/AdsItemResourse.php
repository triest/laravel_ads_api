<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;
    use PhpParser\Node\Expr\Array_;

    class AdsItemResourse extends JsonResource
    {

        public function toArray($model)
        {
            $images = $this->images()->get();

            $url = Array();
            foreach ($images as $image) {
                if ($image != null && $image->downloaded == 1) {
                    $url[] = $image;
                }
            }

            if(empty($url)){
                array_push($url,null);
            }

            return [
                    'data' => [
                            'id' => $this->id,
                            'title' => $this->title,
                            'description' => $this->description,
                            'main_image' => $url[0],
                            'images' => $url,
                            'price' => $this->price
                    ],
            ];
        }
    }
