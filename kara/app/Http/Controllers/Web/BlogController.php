<?php

namespace App\Http\Controllers\Web;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){

        $blogs = Blog::all();
        return view("blog-results",compact("blogs"));
    }
    
}
