<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\UriLog;

/**
 * Class UriLogTransformer.
 *
 * @package namespace App\Transformers;
 */
class UriLogTransformer extends TransformerAbstract
{
    /**
     * Transform the UriLog entity.
     *
     * @param \App\Entities\UriLog $model
     *
     * @return array
     */
    public function transform(UriLog $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
