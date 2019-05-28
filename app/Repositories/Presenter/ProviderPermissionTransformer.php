<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class PermissionTransformer
 * @package namespace App\Transformers;
 */
class ProviderPermissionTransformer extends TransformerAbstract
{

    /**
     * Transform the \Permission entity
     * @param \App\Models\ProviderPermission $permission
     *
     * @return array
     */
    public function transform(\App\Models\ProviderPermission $permission)
    {
        return [
            'id'         => (int) $permission->id,
        ];
    }
}
