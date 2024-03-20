<?php

namespace App\Repositories;

use App\Domains\Enum\Tag\TagStatusEnum;
use App\Models\Company;
use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function model()
    {
        return Tag::class;
    }

    public function getAll()
    {
        $tags = Tag::orderBy('name');
        $tags = Tag::appendToQueryFromRequestQueryParameters($tags);

        return $tags->simplePaginate();
    }

    public function getCompanyTags(Company $company)
    {
        $tags = $company->tags()->orderBy('name');
        $tags = Tag::appendToQueryFromRequestQueryParameters($tags);

        return $tags->simplePaginate();
    }

    public function getTag(Tag|string $tag)
    {
        if (!($tag instanceof  Tag)) {
            $tag = Tag::findOrFail($tag);
        }

        return $tag->load('company');
    }

    public function createCompanyTag(Company $company, $name, $notes, $status = TagStatusEnum::ACTIVE)
    {
        return $company->tags()->create([
             'tenant_id' => $company->tenant_id,
             'notes' => $notes,
             'name' => $name,
             'status' => $status,
         ]);
    }
}
