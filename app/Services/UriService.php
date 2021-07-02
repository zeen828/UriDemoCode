<?php

namespace App\Services;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UriSrtCreateRequest;
use App\Http\Requests\UriSrtUpdateRequest;
use App\Repositories\UriSrtRepository;
use App\Validators\UriSrtValidator;
// Redis
use Illuminate\Support\Facades\Redis;
// Event
use App\Events\goUriSrt;
// 輔助工具
use Illuminate\Support\Str;
use Carbon\Carbon;

class UriService
{
    /**
     * @var UriSrtRepository
     */
    protected $repository;

    /**
     * @var UriSrtValidator
     */
    protected $validator;

    /**
     * UriSrtsController constructor.
     *
     * @param UriSrtRepository $repository
     * @param UriSrtValidator $validator
     */
    public function __construct(UriSrtRepository $repository, UriSrtValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function registerUriSrt($input)
    {
        $srt = '';
        // 長度(資料庫設計10)
        $length = 8;
        // 7天時效
        $expire = Carbon::now()->setTimezone('Asia/Taipei')->addDays(7)->toDateTimeString();
        do {
            // 產生一個亂碼
            $srt = Str::random($length);
            // 檢查Redis
            $dataRedis = $this->repository->getRedisBySrt($srt);
            // 檢查DB
            $dataDb = $this->repository->getCriteriaBySrt($srt);
        } while(!empty($dataRedis) && !empty($dataDb));
        $dataCreate = [
            'srt' => $srt,
            'uri' => sprintf('/go/%s', $srt),
            'go_url' => $input['url'],
            'access' => 0,
            'status' => 1,
            'expire_at' => $expire,
        ];
        // 寫DB
        $data = $this->repository->save($dataCreate)->toArray();
        // 寫Redis
        $this->repository->saveRedisBySrt($srt, $data);
        // 拼湊網址
        $data['url'] = url(sprintf('/go/%s', $data['srt']));
        $data['urlInfo'] = url(sprintf('/go/%s/info', $data['srt']));

        return $data;
    }

    public function getRedisGoUrlBySrt($input)
    {
        $dataRedis = $this->repository->getRedisBySrt($input['srt']);
        if(empty($dataRedis)) {
            abort(404);
            return false;
        }
        $data = json_decode($dataRedis, true);
        $data['url'] = $input['url'];
        $data['ip'] = $input['ip'];

        // Event(1.累計,2.LOG)
        event(new goUriSrt($data));

        return $data;
    }

    public function getSrtUriBySrt($input)
    {
        $data = $this->repository->getCriteriaBySrt($input['srt'])->toArray();
        if(empty($data)){
            abort(404);
            return false;
        }
        $data['url'] = url(sprintf('/go/%s', $data['srt']));

        return $data;
    }
}