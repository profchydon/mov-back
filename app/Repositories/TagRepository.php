<?php

namespace App\Repositories;

use App\Domains\Enum\Tag\TagStatusEnum;
use App\Http\Resources\Tag\TagResource;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Tag;
use App\Models\Taggable;
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

        return new TagResource($tag->load('assets'));
    }

    public function createCompanyTag(Company $company, $name, $notes, $user, $status = TagStatusEnum::ACTIVE)
    {
        return $company->tags()->create([
            'tenant_id' => $company->tenant_id,
            'notes' => $notes,
            'name' => $name,
            'created_by' => $user,
            'status' => $status,
        ]);
    }

    public function assignTagtoAsset(Asset|string $asset, Tag|string $tag)
    {
        if (!($asset instanceof Asset)) {
            $asset = Asset::findOrFail($asset);
        }

        if (!($tag instanceof Tag)) {
            $tag = Tag::findOrFail($tag);
        }

        return Taggable::firstOrCreate([
            'tag_id' => $tag->id,
            'taggable_type' => $asset::class,
            'taggable_id' => $asset->id,
        ]);
    }
}
