<?php

    namespace App\Http\Controllers;


    use App\Builders\AdsBuilder;
    use App\Http\Requests\CreateAdsRequest;
    use App\Http\Resources\AdsItemResourse;
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
            $ads = Ads::select(['*'])->orderBy($orderBy, $order)->paginate('5');
            return AdsResourse::collection($ads);
            //  return response()->json(collect($ads), 200);
        }

        public function getOne($id)
        {

            $ads = Ads::findOrFail(intval($id));

            return new AdsItemResourse($ads);
        }


        /**
         * @param CreateAdsRequest $request
         * @return JsonResource
         */
        public function store(CreateAdsRequest $request)
        {

            $adsBuilder = new AdsBuilder();
            $adsBuilder->setTitle($request->title);
            $adsBuilder->setDescription($request->description);
            $adsBuilder->setPrice($request->price);
            $adsBuilder->setTitle($request->title);

            if ($request->has('image')) {
                $adsBuilder->addImages($request->image);
            }

            $ads = $adsBuilder->getResult();

            return response()->json(['id' => $ads->id], 201);
        }
    }
