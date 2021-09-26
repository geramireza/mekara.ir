<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\City;
use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use App\Post;
use App\PostView;
use App\User;
use App\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
{
    public function index()
    {
        $lastPosts = Post::where(["is_pay" => 1, "is_enable" => 1, "is_emergency" => 0])
            ->orderBy('published_at', 'DESC')
            ->limit(10)
            ->get(['title', 'slug', 'fee', 'fee_type', 'city', 'view_count', 'published_at']);

        $emergencies = Post::where([["is_pay", 1], ["is_enable", 1], ["is_emergency", ">", 0]])
            ->orderBy('published_at', 'DESC')
            ->limit(12)
            ->get(['title', 'slug', 'fee', 'fee_type', 'city', 'view_count', 'published_at']);

        $categories = $this->getCategories();
        $cities = $this->getCities();

        return view("index", compact("lastPosts", "emergencies", "cities", "categories"));
    }

    public function morePosts($param)
    {
        if ($param == "emergency"):
            $posts = Post::where([["is_pay", 1], ["is_enable", 1], ["is_emergency", ">", 0]])
                ->orderBy('published_at', 'DESC')
                ->paginate(10, ['title', 'slug', 'img1', 'img2', 'img3', 'is_emergency', 'fee', 'view_count', 'fee_type', 'city', 'published_at'])->onEachSide(2);
        else:
            $posts = Post::where(["is_pay" => 1, "is_enable" => 1, "is_emergency" => 0])
                ->orderBy('published_at', 'DESC')
                ->paginate(10, ['title', 'slug', 'img1', 'img2', 'img3', 'is_emergency', 'fee', 'view_count', 'fee_type', 'city', 'published_at'])->onEachSide(2);
        endif;
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("search", compact("posts", "categories", "cities"));
    }

    public function getMoreViews()
    {
        $posts = Post::where(["is_pay" => 1, "is_enable" => 1])
            ->orderBy('view_count', 'DESC')
            ->orderBy('published_at', 'DESC')
            ->paginate(10, ['title', 'slug', 'img1', 'img2', 'img3', 'is_enable', 'is_emergency', 'fee', 'view_count', 'fee_type', 'city', 'published_at'])->onEachSide(2);

        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("search", compact("posts", "categories", "cities"));
    }

    public function show($slug)
    {
        $post = Post::where("slug", $slug)->first();
        if ($post) {
            if ($post->is_enable) :
                $userAgent = \Request::header("User-Agent");
                $postView = PostView::where("post_id",$post->id)->where("user_agent",$userAgent)->first();
                if (!$postView){
                    $userAgent = strlen($userAgent) < 250 ? $userAgent : null;
                    PostView::create([
                        "post_id" => $post->id,
                        "user_agent" => $userAgent,
                        "client_ip" => \Request::getClientIp(),
                    ]);
                }
                $post->view_count = PostView::where("post_id", $post->id)->count();
                $post->save();
            endif;
            $post->bookmark = false;
            if (isLogin()) {
                $bookmarkIds = explode(",", user()->post_id_marked);
                $post->bookmark = in_array($post->id, $bookmarkIds);
            }
            $post->category = Category::find($post->category_id)->title;
            $post->phone = User::find($post->user_id)->phone;
            $relatedPosts = $this->getRelatedPosts($post->category_id, $post->post_token);
            $categories = $this->getCategories();
            $cities = $this->getCities();
            $reports = $this->getReportsTitle();

            return view("show", compact("post", "relatedPosts", "categories", "cities", "reports"));

        } else
            return abort("404", "این آگهی بر روی کارا یافت نشد");
    }

    public function showWithToken($token)
    {
        $post = Post::where("post_token", $token)->first();
        if ($post) {
            if ($post->is_enable) :
                $userAgent = \Request::header("User-Agent");
                $postView = PostView::where("post_id",$post->id)->where("user_agent",$userAgent)->first();
                if (!$postView){
                    $userAgent = strlen($userAgent) < 250 ? $userAgent : null;
                    PostView::create([
                        "post_id" => $post->id,
                        "user_agent" => $userAgent,
                        "client_ip" => \Request::getClientIp(),
                    ]);
                }
                $post->view_count = PostView::where("post_id", $post->id)->count();
                $post->save();
            endif;
            $user = User::find($post->user_id);
            $post->phone = $user->phone;
            $bookmarkIds = explode(",", $user->post_id_marked);
            $post->bookmark = in_array($post->id, $bookmarkIds);
            $post->category = Category::find($post->category_id)->title;

            $relatedPosts = $this->getRelatedPosts($post->category_id, $post->post_token);
            $categories = $this->getCategories();
            $cities = $this->getCities();
            $reports = $this->getReportsTitle();
            return view("show", compact("post", "relatedPosts", "categories", "cities", "reports"));
        } else
            return abort("404", "این آگهی بر روی کارا یافت نشد");
    }
    
    public function getSearch($param = null)
    {
        $sql = "";
        $params=[];
        if ($param != null) {
            $array_data = explode("&", $param);
            foreach ($array_data as $array_key => $array_value) {
                $array_list = explode("=", $array_value);
                $label = $array_list[0];
                $values = explode(",", $array_list[1]);
                $params [$array_list[0]] = $values;

                $sql = count($values) > 1 ? $sql . "( " : $sql;

                foreach ($values as $array_key2 => $array_value2) {

                    if ($label == "fee") {
                        if ($array_key2 == 0) {
                            if ($array_value2 == 1)
                                $sql = $sql . "fee < 1000000 ";
                            elseif ($array_value2 == 2)
                                $sql = $sql . "fee BETWEEN 1000000 AND 3000000 ";
                            elseif ($array_value2 == 3)
                                $sql = $sql . "fee >= 3000000 ";
                        } else {
                            if ($array_value2 == 1)
                                $sql = $sql . "OR fee < 1000000 ";
                            elseif ($array_value2 == 2)
                                $sql = $sql . "OR fee BETWEEN 1000000 AND 3000000 ";
                            elseif ($array_value2 == 3)
                                $sql = $sql . "OR fee >= 3000000 ";
                        }
                    } else {
                        if ($label != "city")
                            $sql = $array_key2 == 0 ? $sql . $label . " = " . $array_value2 : $sql . " OR " . $label . " = " . $array_value2;
                        else
                            $sql = $array_key2 == 0 ? $sql . $label . " LIKE '%" . $array_value2 . "%'" : $sql . " OR " . $label . " LIKE '%" . $array_value2 . "%'";
                    }

                }

                $sql = count($values) > 1 ? $sql . " ) " : $sql;

                $sql = $array_key != count($array_data) - 1 ? $sql . " AND " : $sql;
            }

        }

        $sql = $param == null ? " is_pay = 1 AND is_enable = 1 ORDER BY published_at DESC " : $sql . " AND is_pay = 1 AND is_enable = 1 ORDER BY published_at DESC ";

        $posts = DB::table("posts")
            ->whereRaw($sql)
            ->paginate(10, ['title', 'slug', 'img1', 'img2', 'img3', 'is_emergency', 'fee', 'view_count', 'fee_type', 'city', 'published_at'])->onEachSide(2);
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("search", compact("posts", "categories", "cities", "params"));
    }

    public function reSearch(Request $request)
    {
        $txtSearch = $request->txtSearch;
        $category_id = $request->category_id;
        $city_item = $request->city;

        $posts = Post::where(["is_pay" => 1, "is_enable" => 1]);
        if ($city_item != null)
            $posts->where("city", 'like', '%' . $city_item . '%');
        if ($category_id != null)
            $posts->where("category_id", $category_id);

        $txtSearchs = preg_split("/\\s+/", $txtSearch, -1, PREG_SPLIT_NO_EMPTY);

        $txtSearchs = array_diff($txtSearchs,["و","از","به","که","در","با","تا"]);
        $posts = $posts->where(function ($query) use ($txtSearchs, $txtSearch) {
            $query->orWhere("title", "LIKE", "%{$txtSearch}%")->orWhere("body", "LIKE", "%{$txtSearch}%");
            foreach ($txtSearchs as $search) {
                $query->orWhere("title", "LIKE", "%{$search}%")->orWhere("body", "LIKE", "%{$search}%");
            }
        })
            ->orderBy("published_at", "DESC")
            ->paginate(10, ['title', 'slug', 'img1', 'img2', 'img3', 'is_emergency', 'fee', 'view_count', 'fee_type', 'city', 'published_at'])->onEachSide(2);

        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("search", compact("posts", "categories", "cities", "category_id", "city_item", "txtSearch"));
    }

    public function getSearchWithOtherParam($param = null)
    {
        $array_data = [];
        $posts = Post::where(["is_pay" => 1, "is_enable" => 1]);
        if ($param) {
            $params = explode("&", $param);
            foreach ($params as $key => $item) {
                $array_params = explode("=", $item);
                $array_data[$array_params[0]] = $array_params[1];
            }
            if (isset($array_data["is_emergency"]))
                $posts->where("is_emergency", ">", 0);
            if ($array_data["city"] != "all")
                $posts->where("city", "like", "%{$array_data['city']}%");
            if (isset($array_data['category_id']))
                $posts->where("category_id", $array_data['category_id']);
            if (isset($array_data['is_today']))
                $posts->whereDate("published_at", Carbon::today());
            if (isset($array_data["txtSearch"])) {
                $txtSearch = $array_data["txtSearch"];
                $txtSearchs = preg_split("/\\s+/", $txtSearch, -1, PREG_SPLIT_NO_EMPTY);
                $posts->where(function ($query) use ($txtSearchs, $txtSearch) {
                    $query->orWhere("title", "LIKE", "%{$txtSearch}%")->orWhere("body", "LIKE", "%{$txtSearch}%");
                    foreach ($txtSearchs as $search) {
                        $query->orWhere("title", "LIKE", "%{$search}%")->orWhere("body", "LIKE", "%{$search}%");
                    }
                });
            }
        }
        $posts = $posts->orderBy("published_at", "DESC")
            ->paginate(10, ['title', 'slug', 'img1', 'img2', 'img3', 'is_emergency', 'fee', 'view_count', 'fee_type', 'city', 'published_at'])->onEachSide(2);

        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("search", compact("posts", "categories", "cities","array_data"));
    }

    public function create()
    {
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("create", compact("categories", "cities"));
    }

    public function store(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'fee_type' => 'required|in:0,1,2',
            'fee_value' => 'required_unless:fee_type,0',
            'category_id' => 'required|gt:0|lt:15',
            'city' => 'required',
            'post_type' => 'required|in:0,1',
            'phone' => 'required|starts_with:09|digits:11',
            'img' => 'array',
            'img.*' => 'nullable|image|mimes:jpeg,jpg,bmp,png|max:3072|dimensions:min_width=500,min_height=400',
        ], [
            'required' => 'پر کردن این فیلد الزامی است',
            'min' => 'تعداد کاراکتر های این فیلد باید حداقل :min کاراکتر باشد',
            'img.*.mimes' => 'فرمت تصویر باید یکی از فرمت های: jpeg,png,jpg باشد.',
            'img.*.max' => 'حجم تصویر نمی تواند بیشتر از 3M باشد',
            'img.*.dimensions' => 'اندازه عکس باید حداقل 400 * 500 پیکسل باشد',
            'phone.starts_with' => 'فرمت موبایل صحیح نیست',
            'phone.digits' => 'تعداد ارقام موبایل به درستی وارد نشده است',
            'required_unless' => 'پر کردن صحیح این فیلد الزامی است',
            'in' => "مقدار وارد شده صحیح نمی باشد",
            'gt' => 'مقدار وارد شده صحیح نمی باشد',
            'lt' => 'مقدار وارد شده صحیح نمی باشد',
        ]);

        if ($validator->fails())
            return Redirect::back()->withErrors($validator->messages())->withInput();
        
        $user = Auth::register($request->phone);

        $filePath1 = $filePath2 = $filePath3 = null;
        if ($request->hasFile("img.img1")) {
            $filePath1 = Utils::uploadImageFile($request->file("img.img1"));
        }
        if ($request->hasFile("img.img2")) {
            $filePath2 = Utils::uploadImageFile($request->file("img.img2"));
        }
        if ($request->hasFile("img.img3")) {
            $filePath3 = Utils::uploadImageFile($request->file("img.img3"));
        }
        $fee_value = is_numeric($request->fee_value) ? $request->fee_value : 0;
        $post = Post::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => $request->title,
                'body' => $request->body,
                'city' => $request->city
            ],
            [
            'user_id' => $user->id,
            'title' => $request->title,
            'post_token' => Str::random(12) . $request->category_id,
            'body' => $request->body,
            'fee_type' => $fee_value == 0 ? 0 : $request->fee_type,
            'fee' => $fee_value,
            'category_id' => $request->category_id,
            'city' => $request->city,
            'post_type' => $request->post_type,
            'img1' => $filePath1,
            'img2' => $filePath2,
            'img3' => $filePath3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        if (!isLoginWithThisPhone($request->phone))
            UserController::sendPassword();

        if ($post->exists):
            Alert::html('<span class="IranBold16 fw-600 text-success">ایجاد شد</span>', '<div class="Iran14 fw-600 text-info">آگهی شما با موفقیت ایجاد شد. جهت انتشار آن را ارتقاء دهید.</div>', 'success');
            return redirect("manage/preview/$post->post_token");
        else:
            return Redirect::back()->withErrors($validator->messages())->withInput();
        endif;

    }

    public function update(Request $request, $post_token)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'fee_type' => 'required|in:0,1,2',
            'fee_value' => 'required_unless:fee_type,0',
            'category_id' => 'required|gt:0|lt:15',
            'city' => 'required',
            'phone' => 'required|starts_with:09|digits:11',
            'img' => 'array',
            'img.*' => 'nullable|image|mimes:jpeg,jpg,bmp,png|max:3072|dimensions:min_width=500,min_height=400',
        ], [
            'required' => 'پر کردن این فیلد الزامی است',
            'min' => 'تعداد کاراکتر های این فیلد باید حداقل :min کاراکتر باشد',
            'img.*.mimes' => 'فرمت تصویر باید یکی از فرمت های: jpeg,png,jpg باشد.',
            'img.*.max' => 'حجم تصویر نمی تواند بیشتر از 3M باشد',
            'img.*.dimensions' => 'اندازه عکس باید حداقل 400 * 500 پیکسل باشد',
            'phone.starts_with' => 'فرمت موبایل صحیح نیست',
            'phone.digits' => 'تعداد ارقام موبایل به درستی وارد نشده است',
            'required_unless' => 'پر کردن صحیح این فیلد الزامی است',
            'in' => "مقدار وارد شده صحیح نمی باشد",
            'gt' => 'مقدار وارد شده صحیح نمی باشد',
            'lt' => 'مقدار وارد شده صحیح نمی باشد',
        ]);

        if ($validator->fails())
            return Redirect::back()->withErrors($validator->messages())->withInput();

        $user = Auth::register($request->phone);
        $fee_value = is_numeric($request->fee_value) ? $request->fee_value : 0;
        $post = Post::where("post_token", $post_token)->first();
        $filePath1 = $filePath2 = $filePath3 = null;
        if ($request->hasFile("img.img1")) {
            $filePath1 = Utils::uploadImageFile($request->file("img.img1"));
            Utils::deleteImagePost($post->img1);
        }
        if ($request->hasFile("img.img2")) {
            $filePath2 = Utils::uploadImageFile($request->file("img.img2"));
            Utils::deleteImagePost($post->img2);
        }
        if ($request->hasFile("img.img3")) {
            $filePath3 = Utils::uploadImageFile($request->file("img.img3"));
            Utils::deleteImagePost($post->img3);
        }

        if ($post->title != $request->title || $post->body != $request->body || $request->hasFile("img.*")) {
            $post->is_update = 1;
            $post->is_enable = 0;
        }
        $post->user_id = $user->id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->city = $request->city;
        $post->fee_type = $fee_value == 0 ? 0 : $request->fee_type;
        $post->fee = $fee_value;
        $post->category_id = $request->category_id;
        $post->img1 = $filePath1 ?: $post->img1;
        $post->img2 = $filePath2 ?: $post->img2;
        $post->img3 = $filePath3 ?: $post->img3;
        $post->updated_at = Carbon::now();
        $post->save();

        if (!isLoginWithThisPhone($request->phone))
            UserController::sendPassword();

        Alert::html('<span class="IranBold16 fw-600 text-success">ویرایش شد</span>', '<div class="Iran14 fw-600 text-info">آگهی با موفقیت ویرایش شد</div>', 'success');

        return redirect("manage/pay/$post->post_token");
    }

    public function edit($id)
    {
        $categories = $this->getCategories();
        $cities = $this->getCities();
        $post = Post::find($id);
        return view("edit", compact("post", "categories", "cities"));
    }

    public function rePublishPost($post_token)
    {
        $post = Post::where("post_token", $post_token)->first();
        $post->is_delete = 0;
        $post->deleted_at = null;
        $post->updated_at = Carbon::now();
        $post->save();
        return Redirect::route("manage", ["param" => "preview", "token" => $post_token]);
    }

    public function delete($post_token)
    {
        $post = Post::where("post_token", $post_token)->first();
        $post->is_delete = 1;
        $post->is_enable = 0;
        $post->deleted_at = Carbon::now();
        $post->updated_at = Carbon::now();
        $post->save();
        return Redirect::to("my-kara/my-posts");
    }

    public function managePosts($param, $token)
    {
        $post = Post::where("post_token", $token)->first();
        if ($post) {
            $user = User::find($post->user_id);
            $post->category = Category::find($post->category_id)->title;
            $post->phone = $user->phone;
            $bookmarkIds = explode(",", $user->post_id_marked);
            $post->bookmark = in_array($post->id, $bookmarkIds);
            $categories = $this->getCategories();
            $cities = $this->getCities();
            $reports = $this->getReportsTitle();
            $price = $this->getPrices();
            return view("manage-posts", compact("param", "post", "cities", "categories", "reports", "price"));
        } else
            return abort(404, "شما آگهی ای با این مشخصات ندارید");
    }

    public function myKara($param = "my-posts")
    {
        $user = user();
        if ($user) {
            if ($param == "my-posts") :
                $posts = Post::where(["user_id" => $user->id, "is_expired" => 0, "is_delete" => 0])->orderBy("updated_at", "DESC")->paginate(10)->onEachSide(2);
            elseif ($param == "my-bookmarks") :
                $bookmarkIds = explode(",", $user->post_id_marked);
                $implodBookIds = implode(",", array_reverse($bookmarkIds));
                $posts = Post::where("is_enable",1)->whereIn("id", $bookmarkIds)->orderByRaw(DB::raw("FIELD(id, $implodBookIds)"))->paginate(10)->onEachSide(2);
            elseif ($param == "my-deleted") :
                $posts = Post::where("user_id", $user->id)->where(function ($query) {
                    $query->where("is_delete", 1)
                        ->orWhere("is_expired", 1);
                })->orderBy("deleted_at", "DESC")->paginate(10)->onEachSide(2);
            else:
                abort("404","page not found");
            endif;
            return view("my-kara")->with("param", $param)->with("posts", $posts);
        }
    }

    public function bookmark()
    {
        $postId = Input::post("postId");
        $user = User::where("phone", getPhone())->first();
        $postIdMarked = $user->post_id_marked;
        $postIds = [];

        if (!empty($postIdMarked))
            $postIds = explode(",", $postIdMarked);

        if (in_array($postId, $postIds)) {
            $postIds = array_diff($postIds, [$postId]);
            $result['status'] = 0;
            $result['text'] = "UnMarked";
        } else {
            array_push($postIds, $postId);
            $result['status'] = 1;
            $result['text'] = "Marked";
        }

        $user->update(["post_id_marked" => implode(",", $postIds)]);
        return response()->json($result);

    }

    public function deleteBookmark(Request $request)
    {
        $postToken = $request->postToken;
        $user = User::where("phone", getPhone())->first();
        $post = Post::where("post_token", $postToken)->first();
        $postIdMarked = $user->post_id_marked;
        $postIds = explode(",", $postIdMarked);
        $postIds = array_diff($postIds, [$post->id]);
        $user->update(["post_id_marked" => implode(",", $postIds)]);
        return back();
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function getCities()
    {
        return City::all();
    }

    public function getReportsTitle()
    {
        return DB::table("reports_title")->get();
    }

    public function getRelatedPosts($category_id, $token)
    {
        return $relatedPosts = Post::where(["is_pay" => 1, "is_enable" => 1, "category_id" => $category_id])
            ->where("post_token", "!=", $token)
            ->limit(4)
            ->orderBy("published_at", "DESC")
            ->get(['title', 'slug', 'post_token', 'img1', 'img2', 'img3', 'is_emergency', 'fee', 'view_count', 'fee_type', 'city', 'published_at']);
    }

    public function getPrices()
    {
        return DB::table("post_publish_prices")->first();
    }

}
