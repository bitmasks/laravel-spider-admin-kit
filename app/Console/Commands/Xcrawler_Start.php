<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use XCrawler\XCrawler;

class Xcrawler_Start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'xcrawler:start';
    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'xcrawler:start';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->addData();
    }

    // 爬虫1
    public function addData() {

        $xcrawler = new XCrawler([

            'log' => [
                // 日志文件路径
                'path' => storage_path('log/xcrawler/' . date('Y-m-d') . '.log'),
            ],

            'name'     => 'dytt8:index',
            'requests' => function () {
                $url = 'http://www.dytt8.net/';
                yield $url;
            },
            'success'  => function ($result, $request, $xcrawler) {

                // 把html的编码从gbk转为utf-8
                $result = iconv('GBK', 'UTF-8', $result);
                $crawler = new Crawler();
                $crawler->addHtmlContent($result);

                $list = [];
                // 通过css选择器遍历影片列表
                $tr_selector = '#header > div > div.bd2 > div.bd3 > div:nth-child(2) > div:nth-child(1) > div > div:nth-child(2) > div.co_content8 tr';
                $crawler->filter($tr_selector)->each(function (Crawler $node, $i) use (&$list) {
                    $name = dom_filter($node, 'a:nth-child(2)', 'html');
                    if (empty($name)) {
                        return;
                    }
                    $url = 'http://www.dytt8.net' . dom_filter($node, 'a:nth-child(2)', 'attr', 'href');

                    $data = [
                        'name' => $name,
                        'url'  => $url,
                        'time' => dom_filter($node, '.inddline font', 'html'),
                    ];
                    // 把影片url、name推送到redis队列，以便进一步爬取影片下载链接
                    redis()->lpush('dytt8:detail_queue', json_encode($data));
                    $list[] = $data;
                });
                var_dump($list);

                $data['time'] = date('Y-m-d H:i:s');
                $data['uuid'] = rand(1, 1000);
                $data['html'] = $result;
                $data['json'] = json_encode(['list' => $list], JSON_UNESCAPED_UNICODE);
                $id = DB::table('data_test')->insertGetId($data);
                if ($id) {
                    Log::info('定时/数据插入成功', []);
                } else {
                    Log::error('定时/数据插入失败', []);
                }
            }
        ]);
        $xcrawler->run();


    }

}
