<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\PaymentRoleRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class PaymentRoleRepository extends BaseRepository implements PaymentRoleRepositoryInterface
{


    public function boot()
    {
        $this->fieldSearchable = config('model.payment_roles.payment_role.model.search');
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return config('model.payment_roles.payment_role.model.model');
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
