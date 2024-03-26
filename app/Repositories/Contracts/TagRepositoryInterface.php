<?php

namespace App\Repositories\Contracts;

use App\Domains\Enum\Tag\TagStatusEnum;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Tag;

interface TagRepositoryInterface
{
    public function getCompanyTags(Company $company);

    public function createCompanyTag(Company $company, $name, $notes, $status = TagStatusEnum::ACTIVE);

    public function getTag(Tag|string $tag);

    public function assignTagtoAsset(Asset|string $asset, Tag|string $tag);
}
