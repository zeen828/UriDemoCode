<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UriSrtCreateRequest;
use App\Http\Requests\UriSrtUpdateRequest;
use App\Repositories\UriSrtRepository;
use App\Validators\UriSrtValidator;
// Criteria
// use App\Criteria\UriSrt\IndexCriteria;
// Redis
use Illuminate\Support\Facades\Redis;
// Event
use App\Events\goUriSrt;

class HomeController extends Controller
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

    public function index(Request $request)
    {
        $view = [
            'title' => '短網址產生器',
            'method' => 'post',
            'action' => '/',
        ];
        return view('home.index', $view);
    }

    public function post(Request $request)
    {
        $url = $request->input('url');
        // 註冊短字串
        $data = $this->repository->registerUriSrt($url);

        $url = url(sprintf('/go/%s', $data['srt']));
        $urlInfo = url(sprintf('/go/%s/info', $data['srt']));

        $view = [
            'title' => '短網址產生器',
            'method' => 'post',
            'action' => '/',
            'url' => $url,
            'urlInfo' => $urlInfo,
        ];
        $view = array_merge($view, $data);
        return view('home.index', $view);
    }

    public function go(Request $request, $srt)
    {
        $key = sprintf('uri:key:%s', $srt);
        $data = Redis::get($key);
        if(empty($data)) {
            abort(404);
            return false;
        }
        $data = json_decode($data, true);
        $data['url'] = $request->url();
        $data['ip'] = $request->ip();

        // Event(1.累計,2.LOG)
        event(new goUriSrt($data));

        return redirect()->away($data['go_url']);
    }

    public function info(Request $request, $srt)
    {
        $this->repository->pushCriteria(app('App\Criteria\UriSrt\IndexCriteria'));
        // $demo = $this->repository->all();
        $data = $this->repository->where('srt', $srt)->first();
        if(empty($data)){
            abort(404);
            return false;
        }

        $view = [
            'title' => '短網址資訊',
            'srt' => $data->srt,
            'url' => url(sprintf('/go/%s', $data->srt)),
            'go_url' => $data->go_url,
            'access' => $data->access,
            'expire_at' => $data->expire_at,
        ];
        return view('home.info', $view);
    }
}
