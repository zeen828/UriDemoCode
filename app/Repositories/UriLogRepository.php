<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UriLogRepository.
 *
 * @package namespace App\Repositories;
 */
interface UriLogRepository extends RepositoryInterface
{
    // save new
    public function save($data);

    // get all
    public function getAll();

    // get id
    public function getById($id);

    // update id
    public function update($id, $data);
}
