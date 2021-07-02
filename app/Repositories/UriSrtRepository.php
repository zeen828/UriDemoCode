<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UriSrtRepository.
 *
 * @package namespace App\Repositories;
 */
interface UriSrtRepository extends RepositoryInterface
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
