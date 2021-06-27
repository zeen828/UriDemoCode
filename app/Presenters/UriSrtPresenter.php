<?php

namespace App\Presenters;

use App\Transformers\UriSrtTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UriSrtPresenter.
 *
 * @package namespace App\Presenters;
 */
class UriSrtPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UriSrtTransformer();
    }
}
