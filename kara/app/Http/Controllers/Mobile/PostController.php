<?php

namespace App\Http\Controllers\Mobile;

use App\Category;
use App\City;
use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use App\MekaraConfig;
use App\Payment;
use App\Post;
use App\PostView;
use App\User;
use App\Utils;
use App\Constants;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $page = $request->post("page") ?: 1;
        $limit = $request->post("limit") ?: 12;
        $categoryId = $request->has('categoryId') ? $request->post('categoryId') : null;
        $isEmergency = $request->has('isEmergency') ? $request->post('isEmergency') : null;
        $city = $request->has('city') ? $request->post('city') : null;
        $fee = $request->has('fee') ? $request->post('fee') : null;
        $postType = $request->has('postType') ? $request->post('postType') : null;

        $posts = Post::where(["is_pay" => 1,"is_enable" => 1]);

        if ($categoryId)
            $posts = $posts->where('category_id',$categoryId);
        if ($isEmergency)
            $posts = $posts->where('is_emergency',">",0);
        if ($city)
            $posts = $posts->where('city',$city);
        if ($postType)
        {
            $type = trim($postType) == Constants::KEY_KARFARMA ? 0 : 1;
            $posts = $posts->where("post_type",$type);
        }
        if ($fee) {
            $fees = $this->reformatFee($fee); // given a string and return an array
            $posts = $posts->whereBetween('fee', $fees);
        }

    return $posts->orderBy('published_at','DESC')
                ->forPage($page,$limit)
                ->get(['id','user_id AS userId','category_id AS categoryId','title','img1','img2','img3','fee','fee_type AS feeType','is_emergency AS isEmergency',"view_count AS viewCount",'city','published_at AS createdAt']);
    }
    public function show(Request $request)
    {
        $postId = $request->post("postId");
        $phone = $request->post("phone");
        $appToken = $request->has("appToken") ? $request->post("appToken") : null;
        $post = Post::find($postId,['id','user_id','category_id AS categoryId','title','slug','post_token AS postToken','body','img1','img2','img3','post_type AS postType','fee','fee_type AS feeType',"is_extended AS isExtended","is_pay AS isPay","post_life AS postLife",'is_enable AS isEnable','is_emergency AS isEmergency','view_count AS viewCount','city','created_at','published_at AS createdAt']
        );

        if($post){
            if ($post->isEnable):
                $userAgent = $request->header("User-Agent");
                $postView = PostView::where("post_id",$postId)->where("user_agent",$userAgent)->first();
                if (!$postView){
                    $userAgent = strlen($userAgent) < 250 ? $userAgent : null;
                    PostView::create([
                            "post_id" => $postId,
                            "user_agent" => $userAgent,
                            "client_ip" => $request->getClientIp(),
                            "app_token" => $appToken,
                        ]);
                }
                $post->view_count = PostView::where("post_id",$postId)->count();
                $post->save();
            endif;

            $owner = User::find($post->user_id);
            if($phone)
            {
                $user = Auth::register($phone);
                $postIdMarked = $user->post_id_marked;
                $postIds = explode(",",$postIdMarked);
                $isMarked = in_array($postId,$postIds);
            }
            else
                $isMarked = false;

            $post->createdAt = $post->createdAt ?: $post->created_at;
            unset($post->created_at);
            $post->isMarked = $isMarked;
            $post->ownerPhone = $owner->phone;
            $post->link = MekaraConfig::BASE_URL."posts/".$post->slug;
            return response()->json($post);
        }
        else
            return response()->json(null);
    }
    public function store(Request $request){
        $phone = $request->post("phone");
        $postId = $request->post("postId");
        $user = Auth::register($phone);

        $categoryId = $request->post("categoryId");
        $title = $request->post("title");
        $body = $request->post("body");
        $city = $request->post("city");
        $postType = $request->post("postType");
        $fee = str_replace([',',"٬","."],'',convert2En($request->post("fee")));
        $feeType = $fee['type'];
        $feeValue = $fee['value'];
        $images = $request->post("image");
        $isEenable = 0;
        $isUpdate = 0;
        $path[0] = $path[1] = $path[2] = null;
        if (count($images)):
            for ($i = 0; $i < count($images); $i++)
                 $path[$i] = Utils::uploadImageString($images["img".($i + 1)]);
        endif;

        if ($postId > 0)
        {
            $post = Post::find($postId);
            if ($post):
                if ($post->img1)
                    Utils::deleteImagePost($post->img1);
                if ($post->img2)
                    Utils::deleteImagePost($post->img2);
                if ($post->img3)
                    Utils::deleteImagePost($post->img3);

                $isEenable = $post->is_enable;
                $isUpdate = $post->is_update;
                if ($post->title != $title || $post->body != $body) {
                    $isUpdate = 1;
                    $isEenable = 0;
                }
            endif;

            $condition = ["id" => $postId];
        }else
            $condition = ["user_id" => $user->id,"title" => $title,"body" => $body];

         $post = Post::updateOrCreate($condition,[
            "user_id" => $user->id,
            "category_id" => $categoryId,
            "title" => $title,
            "post_token" => Str::random(12).$categoryId,
            "body" => $body,
            "fee" => $feeValue,
            "fee_type" => $feeType,
            "city" => $city,
            "post_type" => $postType,
            "img1" => $path[0],
            "img2" => $path[1],
            "img3" => $path[2],
             "is_update" => $isUpdate,
             "is_enable" => $isEenable,
            "updated_at" => Carbon::now(),
            "created_at" => Carbon::now(),


             //for fee plan
             "is_pay" => 1,
             "post_life" => 30,
             "is_emergency" => rand(0,1)
        ]);

        return Post::find($post->id,["id","is_enable AS isEnable","is_pay AS isPay","is_delete AS isDelete","is_expired AS isExpired","img1","img2","img3"]);

    }

    public function getPostForEdit(Request $request)
    {
        $postId = $request->post("postId");
        $post = Post::find($postId,['id','user_id','category_id AS categoryId','title','slug','post_token AS postToken','body','img1','img2','img3','post_type AS postType','fee','fee_type AS feeType','is_emergency AS isEmergency','view_count AS viewCount'  ,'city','created_at AS createdAt']
        );
       $imageNames = getArrayImageNames([$post->img1,$post->img2,$post->img3]);
        $path = public_path("storage/images/base64/");
        foreach ($imageNames as $key => $name):
            if (file_exists($path.$name))
                $post["img".($key+1)] = file_get_contents($path.$name);
             else
                 $post["img".($key+1)] = null;

        endforeach;

        if($post){
            $owner = User::find($post->user_id);
            $post->ownerPhone = $owner->phone;
            $post->categoryTitle = Category::find($post->categoryId)->title;
            $post->link = MekaraConfig::BASE_URL."posts/".$post->slug;
            return response()->json($post);
        }
        else
            return response()->json(null);
    }

    public function update(Request $request)
    {
        $postId = $request->post("postId");
        $phone = $request->post(Constants::KEY_PHONE);
        $amount = $request->post(Constants::KEY_AMOUNT);
        $referenceId = $request->post(Constants::KEY_REFERENCE_ID);
        $transactionId = $request->post(Constants::KEY_TRANSACTION_ID);

        $post = Post::find($postId);
        $user = User::where("phone",$phone)->first();
        if ($post != null) {
            Payment::create([
                "post_id" => $postId,
                "user_id" => $user->id,
                "amount"  => $amount,
                "gate" => "zarinpalApp",
                "uuid" => null,
                "transaction_id" => $transactionId,
                "status" => 1,
                "reference_id" => $referenceId
            ]);
            $post->post_life = $request->has(Constants::KEY_POST_LIFE) ? $request->post(Constants::KEY_POST_LIFE) : $post->post_life;
            $post->is_emergency = $request->has(Constants::KEY_IS_EMERGENCY) ? 1 : $post->is_emergency;
            $post->published_at = $request->has(Constants::KEY_IS_LADDER) ? Carbon::now() : $post->published_at;
            $post->is_extended = $request->has(Constants::KEY_IS_EXTENDED) ? 1 : $post->is_extended;
            $post->is_pay = 1;
            $post->updated_at = Carbon::now();
            $post->save();
        }

        return $post;
}
    public function delete(Request $request)
    {
        $postId = $request->post("postId");
        $post = Post::find($postId);
        $post->is_delete = 1;
        $post->is_enable = 0;
        $post->deleted_at = Carbon::now();
        $post->updated_at = Carbon::now();
        $result = $post->save() ? true : false;
        return response()->json(["result" => $result]);
    }


    public function rePublish(Request $request)
    {
        $postId = $request->post("postId");
        $post = Post::find($postId);
       if ($post->is_pay == 1)
       {
           $post->is_delete = 0;
           $post->deleted_at = null;
           $post->updated_at = Carbon::now();
           $result = $post->save() ? true : false;
       }else
           $result = false;

        return response()->json(["result" => $result]);
    }

    public function myPost(Request $request)
    {
        $phone = $request->post("phone");
        $page = $request->post("page") ?: 1;
        $user = Auth::register($phone);
        return $posts = Post::where("user_id", $user->id)->orderBy('updated_at', 'DESC')
            ->forPage($page,10)
            ->get(['id', 'user_id AS userId', 'category_id AS categoryId', 'title', 'img1','img2','img3', 'fee', 'fee_type AS feeType', 'is_enable As isEnable',"is_extended AS isExtended","post_life AS postLife",'post_type AS postType','is_delete AS isDelete','is_expired AS isExpired' ,'is_pay As isPay', 'is_emergency AS isEmergency', 'city', 'published_at AS createdAt']);

    }

    public function myView(Request $request)
    {
        $phone = $request->post("phone");
        $user = Auth::register($phone);

        if ($user->app_token == null)
        {
            $result["appToken"] = null;
            return response()->json($result);
        }

        $viewsToday = PostView::where("app_token",$user->app_token)->whereNoTNull("app_token")->whereDate("created_at",Carbon::today())->count();
        $viewsYesterday = PostView::where("app_token",$user->app_token)->whereNoTNull("app_token")->whereDate("created_at",Carbon::yesterday())->count();
        $viewsLastWeek = PostView::where("app_token",$user->app_token)->whereNoTNull("app_token")->whereDate("created_at",">=",Carbon::today()->subDays(7))->count();
        $viewsLastMonth = PostView::where("app_token",$user->app_token)->whereNoTNull("app_token")->whereDate("created_at",">=",Carbon::today()->subDays(30))->count();
        $totalViews = PostView::where("app_token",$user->app_token)->whereNoTNull("app_token")->count();
        $lastDate = PostView::where("app_token",$user->app_token)->whereNoTNull("app_token")->orderBy("created_at","ASC")->first();

        $result["appToken"] = $user->app_token;
        $result["viewsToday"] = $viewsToday;
        $result["viewsYesterday"] = $viewsYesterday;
        $result["viewsLastWeek"] = $viewsLastWeek;
        $result["viewsLastMonth"] = $viewsLastMonth;
        $result["viewsTotal"] = $totalViews;
        $result["timeToday"] = Jalalian::forge(Carbon::today())->format('%A %y/%m/%d');
        $result["timeYesterday"] = Jalalian::forge(Carbon::yesterday())->format('%A %y/%m/%d');
        $result["timeStartWeek"] = Jalalian::forge(Carbon::today()->subDays(7))->format('%A %y/%m/%d');
        $result["timeStartMonth"] = Jalalian::forge(Carbon::today()->subDays(30))->format('%A %y/%m/%d');
        $result["timeStartTotal"] = Jalalian::forge($lastDate ? $lastDate->created_at : Carbon::today())->format('%A %y/%m/%d');
        return response()->json($result);
    }


    public function myBookmark(Request $request)
    {
        $phone = $request->post("phone");
        $page = $request->post("page") ?: 1;
        $user = Auth::register($phone);

        $bookmarkIds = explode(",", $user->post_id_marked);
        $implodBookIds = implode(",", array_reverse($bookmarkIds));
        return $post = Post::where("is_enable",1)->where("user_id","!=",$user->id)->whereIn('id',$bookmarkIds)
                    ->orderByRaw(DB::raw("FIELD(id, $implodBookIds)"))
                    ->forPage($page, 10)
                    ->get(['id', 'user_id AS userId', 'category_id AS categoryId', 'title', 'img1','img2','img3', 'fee', 'fee_type AS feeType', 'is_enable As isEnable', 'is_pay As isPay','view_count AS viewCount', 'is_emergency AS isEmergency', 'city', 'published_at AS createdAt']);

    }
    public function bookmark(Request $request)
    {
        $postId = $request->post("postId");
        $phone = $request->post("phone");

        $user = Auth::register($phone);
        $postIdMarked = $user->post_id_marked;
        $postIds = [];

        if ($postIdMarked != null || $postIdMarked != "")
            $postIds = explode(",", $postIdMarked);

        if (in_array($postId,$postIds))
        {
            $postIds = array_diff($postIds,[$postId]);
            $result['status'] = 0;
            $result['data'] = "UnMarked";
        }
        else
        {
            array_push($postIds,$postId);
            $result['status'] = 1;
            $result['data'] = "Marked";
        }

        $user = $user->update(["post_id_marked" => implode(",",$postIds)]);
        if (!$user)
        {
            $result->status = 2;
            $result->data = "Error";
        }
        return response()->json($result);

    }

    public function search(Request $request)
    {
        $page = $request->has("page") ? $request->post("page") : 1;
         $txtSearch = $request->post("txtSearch");
        $txtSearchs = preg_split("/\\s+/",$txtSearch,-1,PREG_SPLIT_NO_EMPTY);
        $txtSearchs = array_diff($txtSearchs,["و","از","به","که","در","با","تا"]);
        return $posts = Post::where(["is_enable" => 1,"is_pay" => 1])->where(function ($query) use ($txtSearchs,$txtSearch)
        {
            $query->orWhere("title", "LIKE", "%{$txtSearch}%")->orWhere("body", "LIKE", "%{$txtSearch}%");
            foreach ($txtSearchs as $search) {
                $query->orWhere("title", "LIKE", "%{$search}%")->orWhere("body", "LIKE", "%{$search}%");
            }

        })->forPage($page,10)->orderBy("published_at","DESC")->get(['id','user_id AS userId','category_id AS categoryId','title','img1','img2','img3','view_count As viewCount','fee','fee_type AS feeType','is_emergency AS isEmergency' ,'city','published_at AS createdAt']);
    }
    
    public function getCities()
    {
        return City::get();
    }
    public function getPostAndPrices(Request $request)
    {
        $post = Post::find($request->postId,['id as postId',"is_enable AS isEnable","is_emergency AS isEmergency","is_pay AS isPay","post_life AS postLife","post_type AS postType","is_extended AS isExtended", ]);
        $prices = DB::table("post_publish_prices")->latest()->first(["monthly","monthly_karjoo AS monthlyKarjoo","weekly","weekly_karjoo AS weeklyKarjoo","emergency","extended","ladder"]);
        $result["post"] = $post;
        $result["prices"] = $prices;
        return response()->json($result);
    }
    
    public function getFile(Request $request)
    {
        $img = $request->img;
        return file_get_contents(public_path("storage/images/base64/".$img));
    }
    private function reformatFee($fee)
    {
        $fee = convert2En($fee);
        $fee = str_replace([",","٬"," "], "", $fee);
        $fees = explode('-', $fee);
        if ($fees[0] > $fees[1]) {
            $temp = $fees[0];
            $fees[0] = $fees[1];
            $fees[1] = $temp;
        }

        return $fees;
    }


}