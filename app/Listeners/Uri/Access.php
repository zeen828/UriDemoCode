<?php

namespace App\Listeners\Uri;

use App\Events\goUriSrt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
// Model
use App\Repositories\UriSrtRepository;

class Access
{
    protected $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UriSrtRepository $repository)
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
        $this->repository->model()::where('id', $data['id'])
            ->increment('access');
    }
}
