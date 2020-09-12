<?php

    namespace App\Http\Controllers;


    use App\Http\Requests\CreateAdsRequest;
    use App\Http\Resources\AdsResourse;
    use App\Jobs\DownloadImage;
    use App\Models\Ads;
    use App\Models\Image;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;


    class AdsController extends Controller
    {


        public function getAll()
        {
            $ads = Ads::paginate(10);
            return response()->json($ads, 200);
        }

        public function getOne($id)
        {
            return new AdsResourse(Ads::select('*')->where(['id' => $id])->first());
        }


        /**
         * @param CreateAdsRequest $request
         * @return JsonResource
         */
        public function store(CreateAdsRequest $request)
        {

            $ads = new Ads();
            $ads->title = $request->title;
            $ads->description = $request->description;
            $ads->price = $request->price;
            $ads->save();

            if ($request->has('image')) {
                foreach ($request->image as $key) {

                    $image = new Image();
                    $image->url = $key;
                    $image->save();
                    $ads->images()->save($image);
                    DownloadImage::dispatchAfterResponse($image->id);
                }
            }


            return response()->json(['id' => $ads->id], 201);
        }
    }
