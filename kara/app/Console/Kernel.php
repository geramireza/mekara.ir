<?php

namespace App\Console;

use App\Console\Commands\managePosts;
use App\Post;
use App\PostView;
use App\Report;
use App\Utils;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ManagePosts::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('managePosts')
//                  ->everyMinute();

        $schedule->call(function (){
            $posts = Post::where(["is_expired" => 0,"is_pay" => 1])->get();
            foreach ($posts as $post)
            {
                    if ($post->is_emergency):
                        if ($post->is_emergency > 7)
                            $post->is_emergency = 0;
                        else
                            $post->is_emergency += 1;
                    endif;

                    if($post->day_of_post_life > $post->post_life)
                    {
                        if($post->is_extended){
                            $post->is_extended = 0;
                            $post->day_of_post_life -= 7;
                        }else{
                            $post->is_expired = 1;
                            $post->is_pay = 0;
                            $post->is_enable = 0;
                            $post->deleted_at = Carbon::now();
                        }
                    }
                    else
                        $post->day_of_post_life += 1;

                    $post->save();
            }
        });

        $schedule->call(function (){

            $posts = Post::whereDate("published_at" , '<',Carbon::now()->subDays(60))->whereNotNull("published_at")->where(function ($query){
                $query->where("is_pay",0)
                    ->orWhere("is_expired",1);
            })->get();
            foreach ($posts as $post)
            {
                PostView::where("post_id",$post->id)->delete();
                Report::where("post_id",$post->id)->delete();
                if ($post->img1)
                    Utils::deleteImagePost($post->img1);
                if ($post->img2)
                    Utils::deleteImagePost($post->img2);
                if ($post->img3)
                    Utils::deleteImagePost($post->img3);

                $post->delete();
            }

            // the posts not pay at all
            $posts = Post::whereDate("created_at" , '<',Carbon::now()->subDays(30))->whereNull("published_at")->where(function ($query){
                $query->where("is_pay",0)
                    ->orWhere("is_expired",1);
            })->get();
            foreach ($posts as $post)
            {
                PostView::where("post_id",$post->id)->delete();
                Report::where("post_id",$post->id)->delete();
                if ($post->img1)
                    Utils::deleteImagePost($post->img1);
                if ($post->img2)
                    Utils::deleteImagePost($post->img2);
                if ($post->img3)
                    Utils::deleteImagePost($post->img3);

                $post->delete();
            }

        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
