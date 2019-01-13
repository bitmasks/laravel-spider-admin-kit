<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Stat_Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'stat:test';
    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'stat:test';

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

    // 例子
    public function addData() {
        $time = date('Y-m-d H:i:s');
        $rand = rand(1, 1000);
        $id = DB::table('data_test')->insertGetId(['time' => $time, 'uuid' => $rand]);
        if ($id) {
            Log::info('定时/数据插入成功', []);
        } else {
            Log::error('定时/数据插入失败', []);
        }
    }

}
