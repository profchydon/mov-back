<?php

namespace App\Http\Controllers;

use App\Domains\Enum\Tag\TagStatusEnum;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Tag;
use App\Models\Taggable;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Rules\HumanNameRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function __construct(private TagRepositoryInterface $tagRepository)
    {
    }

    public function index(Company $company)
    {
        $tags = $this->tagRepository->getCompanyTags($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $tags);
    }

    public function show(Company $company, Tag $tag, Request $request)
    {
        $tag = $this->tagRepository->getTag($tag);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $tag);
    }

    public function store(Company $company, Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', Rule::unique('tags', 'name')->where('company_id', $company->id)],
            'notes' => ['sometimes']
        ]);

        $tag = $this->tagRepository->createCompanyTag($company, $request->name, $request->notes);

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $tag);
    }

    public function update(Company $company, Tag $tag, Request $request)
    {
        $this->validate($request, [
            'name' => ['sometimes', 'string', Rule::unique('tags', 'name')->where('company_id', $company->id)],
            'status' => ['sometimes', Rule::in(TagStatusEnum::values())],
            'notes' => ['sometimes']
        ]);

        $tag = $this->tagRepository->updateById($tag->id, [
            'name' => $request->name,
            'status' => $request->status ?? $tag->status,
        ]);

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $tag);
    }

    public function destroy(Company $company, Tag $tag, Request $request)
    {
        $this->tagRepository->delete($tag);

        return $this->noContent();
    }

    public function destroyMany(Company $company, Request $request)
    {
        $this->validate($request, [
            'tag_ids' => 'required|array|min:1',
            'tag_ids.*' => [Rule::exists('tags', 'id')->where('company_id', $company->id)]
        ]);

        Tag::whereIn('id', $request->tag_ids)->delete();

        return $this->noContent();
    }

    public function assignAssets(Company $company, Tag $tag, Request $request)
    {

        $this->validate($request, [
            'asset_ids' => 'required|array|min:1',
            'asset_ids.*' => [Rule::exists('assets', 'id')]
        ]);

        $assets = collect($request->asset_ids);
        $assets->transform(function (Asset|string $asset) use ($tag) {
            $this->tagRepository->assignTagtoAsset($asset, $tag);
        });

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $tag->load('assets'));
    }

    public function unAssignAssets(Company $company, Tag $tag, Request $request)
    {

        $this->validate($request, [
            'asset_ids' => 'required|array|min:1',
            'asset_ids.*' => [Rule::exists('assets', 'id')]
        ]);

        $assets = collect($request->asset_ids);

        // Detach the assets from the tag
        $tag->assets()->detach($assets);

        return $this->response(Response::HTTP_OK, __('messages.record-created'), $tag->load('assets'));
    }

}
