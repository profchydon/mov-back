<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\Permission\PermissionResource;
use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Role $Role */
        $roles = $this->resource;

        $data = [];

        foreach ($roles as $role) {

            $permission = $role->permissions;

            array_push($data, [
                'id' => $role->id,
                'name' => $role->name,
                'company_id' => $role->company_id,
                'permissions' => PermissionResource::collection($permission)
            ]);
        }

        return $data;
    }
}
