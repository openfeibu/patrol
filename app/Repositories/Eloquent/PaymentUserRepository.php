<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\PaymentUserRepositoryInterface;

class PaymentUserRepository extends BaseRepository implements PaymentUserRepositoryInterface
{
    /**
     * @var array
     */

    public function boot()
    {
        $this->fieldSearchable = config('model.user.payment_user.model.search');
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        $provider = config("auth.guards." . getenv('guard') . ".provider", 'payment_users');
        return config("auth.providers.$provider.model", \App\Models\PaymentUser::class);
    }

    /**
     * Find a user by its id.
     *
     * @param type $id
     *
     * @return type
     */
    public function findUser($id)
    {
        return $this->model->whereId($id)->first();
    }

    /**
     * Find a agents.
     *
     * @param type $id
     *
     * @return type
     */
    public function agents()
    {
        $temp   = [];
        $agents = $this->model->select('id', 'name')->orderBy('name', 'ASC')->get();

        foreach ($agents as $key => $value) {
            $temp[$value->id] = $value->name;
        }

        return $temp;
    }

    /**
     * Activate user with the given id.
     *
     * @param type $id
     *
     * @return type
     */
    public function activate($id)
    {
        $user = $this->model->whereId($id)->whereStatus('New')->first();

        if (is_null($user)) {
            return false;
        }

        $user->status = 'Active';

        if ($user->save()) {
            return true;
        }

        return false;
    }

}
