<?php

namespace App\Console\Commands;

use Beanbun\Beanbun;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Beanbun_Start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'beanbun:start';
    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'beanbun:start';

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

        //todo  需要安装多进程扩展
        $bean =  new Beanbun;
        $bean->seed = [
            'http://www.950d.com/',
            'http://www.950d.com/list-1.html',
            'http://www.950d.com/list-2.html',
        ];

        $bean->afterDownloadPage = function (){
            $time = date('Y-m-d H:i:s');
            $rand = rand(1, 1000);
            $id = DB::table('data_test')->insertGetId(['time' => $time, 'uuid' => $rand]);
            if ($id) {
                Log::info('定时/数据插入成功', []);
            } else {
                Log::error('定时/数据插入失败', []);
            }
        };
        $bean->start();


    }

}
