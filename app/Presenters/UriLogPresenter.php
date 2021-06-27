<?php

namespace App\Presenters;

use App\Transformers\UriLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UriLogPresenter.
 *
 * @package namespace App\Presenters;
 */
class UriLogPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UriLogTransformer();
    }
}
