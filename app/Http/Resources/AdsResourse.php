<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class AdsResourse extends JsonResource
    {

        public function toArray($model)
        {
            $image = $this->images()->first();

            if($image!=null && $image->downloaded == 1){
                $link=$image->name;
            }else{
                $link=null;
            }
            return [
                    'data' => [
                            'id' => $this->id,
                            'title' => $this->title,
                            'main_image' => $link,
                            'price' => $this->price,
                    ],
            ];
        }
    }
