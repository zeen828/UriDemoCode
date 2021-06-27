<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\UriSrt;

/**
 * Class UriSrtTransformer.
 *
 * @package namespace App\Transformers;
 */
class UriSrtTransformer extends TransformerAbstract
{
    /**
     * Transform the UriSrt entity.
     *
     * @param \App\Entities\UriSrt $model
     *
     * @return array
     */
    public function transform(UriSrt $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
