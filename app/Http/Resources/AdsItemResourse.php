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
                $main_image=null;
            }else{
                $main_image=$url[0]->name;
            }

            return [
                    'data' => [
                            'id' => $this->id,
                            'title' => $this->title,
                            'description' => $this->description,
                            'main_image' =>'storage/'.$main_image,
                            'images' => $url,
                            'price' => $this->price
                    ],
            ];
        }
    }
