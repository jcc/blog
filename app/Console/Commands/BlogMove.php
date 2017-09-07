<?php

namespace App\Console\Commands;

use App\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BlogMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:move';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'move the blog';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = 1;
        $hasImage = 0;
        $posts = DB::table('wp_posts')->where('post_status', 'publish')->get();
        $this->info('总共'.count($posts).'篇文章------------------------');

        DB::transaction(function () use($posts, $start, &$hasImage){
            foreach ($posts as $post){
                $this->info('处理进度：'.$start.'/'.count($posts));

                if ($post->post_title == ''){
                    continue;
                }

                $meta = DB::table('wp_postmeta')->where('post_id', $post->ID)->where('meta_key', '_thumbnail_id')->first();

                $page_image = '';
                if ($meta != null){
                    $attachment = DB::table('wp_posts')->where('id', $meta->meta_value)->where('post_type', 'attachment')->first();

                    if ($attachment != null){
                        $hasImage++;

                        if (str_contains($attachment->guid, 'http://sunnierblog-wordpress.stor.sinaapp.com')){
                            $page_image = str_replace('http://sunnierblog-wordpress.stor.sinaapp.com', 'https://static.xtwind.com', $attachment->guid);
                        }

                        if (str_contains($attachment->guid, 'http://xtwind-wordpress.stor.sinaapp.com')){
                            $page_image = str_replace('http://xtwind-wordpress.stor.sinaapp.com', 'https://static.xtwind.com', $attachment->guid);
                        }

                    }
                }

                DB::table('articles')->insert([
                    'category_id'   =>  1,
                    'user_id'       =>  12,
                    'last_user_id'  =>  12,
                    'slug'          =>  $post->post_name . '.html',
                    'title'         =>  $post->post_title,
                    'subtitle'      =>  '',
                    'content'       =>  json_encode([
                        'raw'   =>  '',
                        'html'  =>  $post->post_content
                    ]),
                    'page_image'    =>  $page_image,
                    'meta_description'  =>  $post->post_excerpt,
                    'is_original'   =>  1,
                    'is_draft'      =>  0,
                    'view_count'    =>  mt_rand(1,10000),
                    'published_at'  =>  $post->post_date,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'updated_at'    =>  date('Y-m-d H:i:s')
                ]);

                $start++;
            }
        }, 5);


        $this->info('处理'.count($posts).'篇文章，其中有图片：'.$hasImage);
    }

}
