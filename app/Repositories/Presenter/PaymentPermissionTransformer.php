<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class PermissionTransformer
 * @package namespace App\Transformers;
 */
class PaymentPermissionTransformer extends TransformerAbstract
{

    /**
     * Transform the \Permission entity
     * @param \App\Models\PaymentPermission $permission
     *
     * @return array
     */
    public function transform(\App\Models\PaymentPermission $permission)
    {
        return [
            'id'         => (int) $permission->id,
        ];
    }
}
