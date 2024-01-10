<?php

namespace App\Repositories\Contracts;

use App\Domains\Enum\Tag\TagStatusEnum;
use App\Models\Company;
use App\Models\Tag;

interface TagRepositoryInterface
{
    public function getCompanyTags(Company $company);

    public function createCompanyTag(Company $company, $name, $status = TagStatusEnum::ACTIVE);

    public function getTag(Tag|string $tag);
}
