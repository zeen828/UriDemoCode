<?php

namespace App\Listeners\Uri;

use App\Events\goUriSrt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
// Model
use App\Repositories\UriLogRepository;

class Log
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UriLogRepository $repository)
    {
        //
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  goUriSrt  $event
     * @return void
     */
    public function handle(goUriSrt $event)
    {
        //
        $data = $event->data;
        // var_dump($data);
        $this->repository->model()::create([
            'srt_id' => $data['id'],
            'srt' => $data['srt'],
            'uri' => $data['uri'],
            'url' => $data['url'],
            'ip' => $data['ip'],
        ]);
    }
}
