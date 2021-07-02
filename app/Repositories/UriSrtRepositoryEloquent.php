<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UriSrtRepository;
use App\Entities\UriSrt;
use App\Validators\UriSrtValidator;
// Redis
use Illuminate\Support\Facades\Redis;
// 輔助工具
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class UriSrtRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UriSrtRepositoryEloquent extends BaseRepository implements UriSrtRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UriSrt::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return UriSrtValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    // save new
    public function save($data)
    {
        return $this->model()::create($data);
    }

    // get all
    public function getAll()
    {
        return $this->get();
    }

    // get id
    public function getById($id)
    {
        return $this->where('id', $id)->first();
    }

    // update id
    public function update($id, $data)
    {
        return $this->where('id', $id)->update($data);
    }

    // 自訂區
    public function getCriteriaById($id)
    {
        $this->pushCriteria(app('App\Criteria\UriSrt\IndexCriteria'));
        return $this->where('id', $id)->first();
    }

    public function getCriteriaBySrt($srt)
    {
        $this->pushCriteria(app('App\Criteria\UriSrt\IndexCriteria'));
        return $this->where('srt', $srt)->first();
    }

    public function accessById($id)
    {
        $this->where('id', $id)->increment('access');
    }

    public function saveRedisBySrt($srt, $data)
    {
        $key = sprintf('uri:key:%s', $srt);
        // Redis::set('key', 'value', 'EX', 60);
        Redis::set($key, json_encode($data), 'EX', 7*24*60*60);
    }

    public function getRedisBySrt($srt)
    {
        $key = sprintf('uri:key:%s', $srt);
        return Redis::get($key);
    }

    // 登記短字串網址
    public function registerUriSrt($go_url)
    {
        $srt = '';
        // 長度(資料庫設計10)
        $length = 8;
        // 7天時效
        $expire = Carbon::now()->setTimezone('Asia/Taipei')->addDays(7)->toDateTimeString();
        // 條件
        $this->pushCriteria(app('App\Criteria\UriSrt\IndexCriteria'));
        // $srt = '12';
        // $dataDb = $this->where('srt', $srt)->first();
        // var_dump($dataDb);
        // exit();
        do{
            // 產生一個亂碼
            $srt = Str::random($length);
            // 檢查Redis
            $key = sprintf('uri:key:%s', $srt);
            $dataRedis = Redis::get($key);
            // 檢查DB
            $dataDb = $this->where('srt', $srt)->first();
        }
        while(!empty($dataRedis) && !empty($dataDb));
        $dataCreate = [
            'srt' => $srt,
            'uri' => sprintf('/go/%s', $srt),
            'go_url' => $go_url,
            'access' => 0,
            'status' => 1,
            'expire_at' => $expire,
        ];
        // 寫DB
        $data = $this->model()::create($dataCreate);
        // 寫Redis
        $key = sprintf('uri:key:%s', $srt);
        // Redis::set('key', 'value', 'EX', 60);
        Redis::set($key, json_encode($data->toArray()), 'EX', 7*24*60*60);

        return $data->toArray();
    }

}
