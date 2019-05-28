<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\ProviderRoleRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class ProviderRoleRepository extends BaseRepository implements ProviderRoleRepositoryInterface
{


    public function boot()
    {
        $this->fieldSearchable = config('model.provider_roles.provider_role.model.search');
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return config('model.provider_roles.provider_role.model.model');
    }

    /**
     * Find a user by its key.
     *
     * @param type $key
     *
     * @return type
     */
    public function findRoleBySlug($key)
    {
        return $this->model->whereSlug($key)->first();
    }
}
