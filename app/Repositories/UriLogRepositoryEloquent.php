<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UriLogRepository;
use App\Entities\UriLog;
use App\Validators\UriLogValidator;

/**
 * Class UriLogRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UriLogRepositoryEloquent extends BaseRepository implements UriLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UriLog::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return UriLogValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    // save new
    public function save($data)
    {
        return $this->model()::create($data);
    }

    // get all
    public function getAll()
    {
        return $this->get();
    }

    // get id
    public function getById($id)
    {
        return $this->where('id', $id)->first();
    }

    // update id
    public function update($id, $data)
    {
        return $this->where('id', $id)->update($data);
    }

    // 自訂區
}
