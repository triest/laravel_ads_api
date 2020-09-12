<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class AdsResourse extends JsonResource
    {

        public function toArray($model)
        {
            $images = $this->images()->first();

            $images_array=array();
            if($images!=null && $images->downloaded==1){
                $url=$images->name;
                $images_array[]=$images;
            }

            return [
                    'data' => [
                            'id' => $this->id,
                            'title' => $this->title,
                            'description' => $this->description,
                            'main_image' => $images_array
                    ],
            ];
        }
    }
