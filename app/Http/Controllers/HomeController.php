<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Service
use App\Services\UriService;

class HomeController extends Controller
{
    protected $uriService;

    public function __construct(UriService $uriService)
    {
        $this->uriService = $uriService;
    }

    public function index(Request $request)
    {
        $result = [];

        if ($request->isMethod('post')) {
            $input = $request->only([
                'url',
            ]);

            $result = $this->uriService->registerUriSrt($input);
        }

        return view('home.index', $result);
    }

    public function go(Request $request, $srt)
    {
        $input = [
            'srt' => $srt,
            'url' => $request->url(),
            'ip' => $request->ip(),
        ];

        $result = $this->uriService->getRedisGoUrlBySrt($input);

        return redirect()->away($result['go_url']);
    }

    public function info(Request $request, $srt)
    {
        $input = [
            'srt' => $srt,
        ];

        $result = $this->uriService->getSrtUriBySrt($input);

        return view('home.info', $result);
    }
}
