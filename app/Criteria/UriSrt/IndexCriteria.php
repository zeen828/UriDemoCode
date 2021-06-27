<?php

namespace App\Criteria\UriSrt;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
// 輔助工具
use Carbon\Carbon;

/**
 * Class IndexCriteria.
 *
 * @package namespace App\Criteria\UriSrt;
 */
class IndexCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        // return $model;
        // 時效
        $expire = Carbon::now()->setTimezone('Asia/Taipei')->toDateTimeString();
        $query = $model->where('status', '=', '1')
            ->whereDate('expire_at', '>=', $expire);

        return $query;
    }
}
