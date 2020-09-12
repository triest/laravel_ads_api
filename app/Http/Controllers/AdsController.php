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


        public function getAll(Request $request)
        {
            if (isset($_GET['orderby']) && ($_GET['orderby'] == "price" || $_GET['orderby'] == "created_at")) {
                $orderBy = $_GET['orderby'];
            } else {
                $orderBy = 'created_at';
            }

            if (isset($_GET['order']) && ($_GET['order'] == "desc" || $_GET['order'] == "asc")) {
                $order = $_GET['order'];
            } else {
                $order = "desc";
            }
            //desc
            $ads = Ads::select(['*'])->orderBy($orderBy, $order)->paginate('10');
            return response()->json($ads, 200);
        }

        public function getOne($id)
        {

            $ads = Ads::find(intval($id));
            return new AdsResourse($ads);
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
