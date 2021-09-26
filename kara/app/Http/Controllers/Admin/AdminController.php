<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Category;
use App\City;
use App\Constants;
use App\Contact;
use App\Helpers\Auth;
use App\Post;
use App\Report;
use App\User;
use App\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Sms;

class AdminController extends Controller
{
    public function index(){

                $totalPosts = Post::where("is_enable",1)->count();
                $totalToday = Post::where("is_enable",1)->whereDate("published_at",Carbon::today())->count();
                $totalInWeek = Post::where("is_enable",1)->whereDate("published_at",">=",Carbon::today()->subDays(7))->count();
                $totalInMonth = Post::where("is_enable",1)->whereDate("published_at",">=",Carbon::today()->subDays(30))->count();
                $totalUsers = User::count();
                
                $countNotConfirmed = $this->getCountNotConfirmed();
                $countEdited = $this->getCountEdited();
                $countReportNotSeen = $this->getCountReportNotSeen();
                $countContactNotSeen = $this->getCountContactNotSeen();
                $categories = $this->getCategories();
                $cities = $this->getCities();
                return view("admin.index",compact("totalPosts","totalToday","totalInWeek","totalInMonth","totalUsers","countNotConfirmed","countEdited","countReportNotSeen","countContactNotSeen","categories","cities"));
     }

    public function create()
    {
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("admin.create",compact("categories","cities"));
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
            'phone' => 'required|starts_with:0|digits:11',
            'img' => 'array',
            'img.*' => 'nullable|image|mimes:jpeg,jpg,bmp,png|max:3072|dimensions:min_width=500,min_height=400',
        ], [
            'required' => 'پر کردن این فیلد الزامی است',
            'min' => 'تعداد کاراکتر های این فیلد باید حداقل :min کاراکتر باشد',
            'img.*.mimes' => 'فرمت تصویر باید یکی از فرمت های: jpeg,png,jpg باشد.',
            'img.*.max' => 'حجم تصویر نمی تواند بیشتر از 3M باشد',
            'img.*.dimensions' =>'اندازه عکس باید حداقل 400 * 500 پیکسل باشد',
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
        if($request->hasFile("img.img1"))
        {
            $filePath1 = Utils::uploadImageFile($request->file("img.img1"));
        }
        if($request->hasFile("img.img2"))
        {
            $filePath2 = Utils::uploadImageFile($request->file("img.img2"));
        }
        if($request->hasFile("img.img3"))
        {
            $filePath3 = Utils::uploadImageFile($request->file("img.img3"));
        }
        $fee_value = (preg_match('/^[۰۱۲۳۴۵۶۷۸۹ًٌٍَُِّ\s]+$/u', $request->fee_value) || is_numeric($request->fee_value)) ? $request->fee_value : 0;
        $post = Post::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'post_token' => Str::random(12).$request->category_id,
            'body' => $request->body,
            'fee_type' => $fee_value == 0 ? 0 : $request->fee_type,
            'fee' => convert2En($fee_value),
            'category_id' => $request->category_id,
            'city' => $request->city,
            'post_type' => $request->post_type,
            'img1' => $filePath1,
            'img2' => $filePath2,
            'img3' => $filePath3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            
        ]);
        
        $post->post_life = 30;
        $post->is_pay = 1;
        $post->is_emergency = $request->has("emergency") ? 1 : 0;
        $post->save();

        if($post->exists)
        {
            Alert::html('<span class="IranBold16 fw-600 text-success">ایجاد شد</span>','<div class="Iran14 fw-600 text-info">آگهی شما با موفقیت ایجاد شد .برای انتشار آن را ارتقا دهید</div>','success');
            return back();
        }
        else
            return Redirect::back()->withErrors($validator->messages())->withInput();

    }

    public function edit(Request $request)
    {

        $categories = $this->getCategories();
        $cities = $this->getCities();
        $post = Post::where("post_token",$request->token)->first();
        $user = User::find($post->user_id);
        $post->phone = $user->phone;
        return view("admin.edit",compact("post","categories","cities"));
    }
    public function delete(Request $request)
    {
        $post = Post::where("post_token",$request->token)->first();
        Report::where("post_id",$post->id)->delete();
        $post->delete();
        return Redirect::route("admin.not-confirmed");
    }
    public function update(Request $request,$post_token)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'fee_type' => 'required|in:0,1,2',
            'fee_value' => 'required_unless:fee_type,0',
            'category_id' => 'required|gt:0|lt:15',
            'city' => 'required',
            'phone' => 'required|starts_with:0|digits:11',
            'img' => 'array',
            'img.*' => 'nullable|image|mimes:jpeg,jpg,bmp,png|max:3072|dimensions:min_width=500,min_height=400',

        ], [
            'required' => 'پر کردن این فیلد الزامی است',
            'min' => 'تعداد کاراکتر های این فیلد باید حداقل :min کاراکتر باشد',
            'img.*.mimes' => 'فرمت تصویر باید یکی از فرمت های: jpeg,png,jpg باشد.',
            'img.*.max' => 'حجم تصویر نمی تواند بیشتر از 3M باشد',
            'img.*.dimensions' =>'اندازه عکس باید حداقل 400 * 500 پیکسل باشد',
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
        $fee_value = (preg_match('/^[۰۱۲۳۴۵۶۷۸۹ًٌٍَُِّ\s]+$/u', $request->fee_value) || is_numeric($request->fee_value)) ? $request->fee_value : 0;

        $post = Post::where("post_token",$post_token)->first();

        $filePath1 = $filePath2 = $filePath3 = null;
        if($request->hasFile("img.img1"))
        {
            $filePath1 = Utils::uploadImageFile($request->file("img.img1"));
            Utils::deleteImagePost($post->img1);
        }
        if($request->hasFile("img.img2"))
        {
            $filePath2 = Utils::uploadImageFile($request->file("img.img2"));
            Utils::deleteImagePost($post->img2);
        }
        if($request->hasFile("img.img3"))
        {
            $filePath3 = Utils::uploadImageFile($request->file("img.img3"));
            Utils::deleteImagePost($post->img3);
        }
        $post->user_id = $user->id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->city = $request->city;
        $post->fee_type = $fee_value == 0 ? 0 : $request->fee_type;
        $post->fee = convert2En($fee_value);
        $post->post_type = $request->post_type;
        $post->is_emergency = $request->has("emergency") ? 1 : 0;
        $post->category_id = $request->category_id;
        $post->img1 = $filePath1 ?: $post->img1;
        $post->img2 = $filePath2 ?: $post->img2;
        $post->img3 = $filePath3 ?: $post->img3;
        $post->updated_at = Carbon::now();
        $post->save();

        Alert::html('<span class="IranBold16 fw-600 text-success">ویرایش شد</span>','<div class="Iran14 fw-600 text-info">آگهی با موفقیت ویرایش شد</div>','success');
        return Redirect::route("posts.show",["slug" => $post->slug]);
    }
    public function notConfirmed(){

        $posts = Post::where(["is_pay" => 1,"is_enable" => 0,"is_update" => 0])
            ->orderBy("created_at","ASC")
            ->paginate(8,['id','user_id','category_id','title','slug','img1','img2','img3','fee','view_count','fee_type','is_emergency','is_enable'  ,'city','created_at AS published_at']);

        $countNotConfirmed = $this->getCountNotConfirmed();
        $countEdited = $this->getCountEdited();
        $countReportNotSeen = $this->getCountReportNotSeen();
        $countContactNotSeen = $this->getCountContactNotSeen();
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("admin.post-results",compact("posts","countNotConfirmed","countEdited","countReportNotSeen","countContactNotSeen","categories","cities"));
    }
    public function confirmed(){

        $posts = Post::where(["is_pay" => 1,"is_enable" => 1])
            ->orderBy("published_at","DESC")
            ->paginate(8,['id','user_id','category_id','title','slug','img1','img2','img3','fee','view_count','fee_type','is_emergency','is_enable'  ,'city','published_at']);

        $countNotConfirmed = $this->getCountNotConfirmed();
        $countEdited = $this->getCountEdited();
        $countReportNotSeen = $this->getCountReportNotSeen();
        $countContactNotSeen = $this->getCountContactNotSeen();
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("admin.post-results",compact("posts","countNotConfirmed","countEdited","countReportNotSeen","countContactNotSeen","categories","cities"));
    }
    public function edited()
    {
        $posts = Post::where(["is_pay" => 1,"is_enable" => 0,"is_update" => 1])
            ->orderBy("updated_at","ASC")
            ->paginate(8,['id','user_id','category_id','title','slug','img1','img2','img3','fee','view_count','fee_type','is_emergency','is_enable'  ,'city','updated_at AS published_at']);

        $countNotConfirmed = $this->getCountNotConfirmed();
        $countEdited = $this->getCountEdited();
        $countReportNotSeen = $this->getCountReportNotSeen();
        $countContactNotSeen = $this->getCountContactNotSeen();
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("admin.post-results",compact("posts","countNotConfirmed","countEdited","countReportNotSeen","countContactNotSeen","categories","cities"));
    }
    public function postsReports()
    {
        $reports = Report::with("post.user:id,phone","user:id,phone")->orderBy("is_seen","ASC")->orderBy('id',"DESC")->paginate(5);
        $countNotConfirmed = $this->getCountNotConfirmed();
        $countEdited = $this->getCountEdited();
        $countReportNotSeen = $this->getCountReportNotSeen();
        $countContactNotSeen = $this->getCountContactNotSeen();
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("admin.report-results",compact("reports","countNotConfirmed","countEdited","countContactNotSeen","countReportNotSeen","categories","cities"));
    }
    public function contactsReports()
    {
        $contacts = Contact::with("user:id,phone")->orderBy("is_seen","ASC")->orderBy('id',"DESC")->paginate(5);
        $countNotConfirmed = $this->getCountNotConfirmed();
        $countEdited = $this->getCountEdited();
        $countReportNotSeen = $this->getCountReportNotSeen();
        $countContactNotSeen = $this->getCountContactNotSeen();
        $categories = $this->getCategories();
        $cities = $this->getCities();
        return view("admin.contact-results",compact("contacts","countNotConfirmed","countEdited","countContactNotSeen","countReportNotSeen","categories","cities"));
    }
    public function enablePost()
    {
        $postToken = Input::post("postToken");
        $checked = Input::post("checked") == "true" ? 1 : 0;
        $post =  Post::where("post_token",$postToken)->first();
        $user = User::find($post->user_id);
        $post->is_enable = $checked;
        $post->is_delete = $checked ? 0 : 1;
        $post->is_update = 0;
        $firstTime = 0;
        if (is_null($post->published_at))
        {
            $firstTime = 1;
            $post->published_at = Carbon::now();
        }
        if (!$checked)
            $post->deleted_at = Carbon::now();
        $result = $post->save();

//        if ($result && $checked && $firstTime)
//        {
//            $sms = new Sms(Constants::API_KEY, Constants::SECURITY_KEY,Constants::API_URL,Constants::LINE_NUMBER);
//            $sms->ultraFastSend($user->phone,$user->phone,Constants::PARAMETER_VERIFY_POST2,Constants::TEMPLATE_ID_VERIFY_POST2);
//        }

        return response()->json($result);
    }
    public function deleteImgPost()
    {
        $postId = Input::post("postId");
        $img = Input::post("img");
        $post =  Post::find($postId);
        Utils::deleteImagePost($post->$img);
        $post->$img = null;
        $result = $post->save();
        return response()->json($result);
    }

    public function deleteReport($param,$reportId)
    {
        if ($param == "report")
          $report =  Report::find($reportId);
        elseif($param == "contact")
          $report =  Contact::find($reportId);
        $result = $report->delete();
        return back();
    }

    public function getCountNotConfirmed()
    {
      return  Post::where(["is_pay" => 1,"is_enable" => 0,"is_update" => 0])->count();
    }


    public function createBlog()
    {
        $blogCategories = DB::table("blog_categories")->get();
        return view("admin.create-blog",compact("blogCategories"));
    }

    public function storeBlog(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'category_id' => 'required|gt:0',
            'img' => 'required|image|mimes:jpeg,jpg,bmp,png|max:3072|dimensions:min_width=500,min_height=400',
        ], [
            'required' => 'پر کردن این فیلد الزامی است',
            'min' => 'تعداد کاراکتر های این فیلد باید حداقل :min کاراکتر باشد',
            'image' => 'فرمت تصویر باید یکی از فرمت های: jpeg,png,jpg باشد.',
            'img.mimes' => 'فرمت تصویر باید یکی از فرمت های: jpeg,png,jpg باشد.',
            'img.max' => 'حجم تصویر نمی تواند بیشتر از 3M باشد',
            'img.dimensions' => 'اندازه عکس باید حداقل 400 * 500 پیکسل باشد',
            ]);

        if ($validator->fails())
            return Redirect::back()->withErrors($validator->messages())->withInput();

        $filePath = Utils::uploadImageFileBlog($request->file("img"));
        $blog =  Blog::create([
            "category_id" => $request->category_id,
            "title" => $request->title,
            "body"  => $request->body,
            "img"    => $filePath,
        ]);

        if ($blog)
            Alert::html('<span class="IranBold16 fw-600 text-success">ایجاد شد</span>', '<div class="Iran14 fw-600 text-info">مقاله شما با موفقیت ایجاد شد.</div>', 'success');

        return back();

    }
    
    public function getCountEdited()
    {
        return  Post::where(["is_pay" => 1,"is_enable" => 0,"is_update" => 1])->count();
    }

    public function getCountReportNotSeen()
    {
        return Report::where("is_seen",0)->count();
    }

    public function getCountContactNotSeen()
    {
        return Contact::where("is_seen",0)->count();
    }
    public function getCategories()
    {
        return Category::all();
    }
    public function getCities()
    {
        return City::all();
    }
}
