<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Repository\PresentableTrait;
use App\Traits\ProviderRoles\RoleHasRelations;
use App\Traits\Trans\Translatable;
use App\Contracts\RoleHasRelations as RoleHasRelationsContract;

class ProviderRole extends BaseModel implements RoleHasRelationsContract
{
    use Filer, Hashids, Slugger, Translatable, PresentableTrait, RoleHasRelations;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.provider_roles.provider_role.model';

    public function setLevelAttribute($value)
    {

        if (empty($value)) {
            return $this->level = 1;
        }

        return $this->level = $value;
    }

}
