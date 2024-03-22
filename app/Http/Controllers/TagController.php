<?php

namespace App\Http\Controllers;

use App\Domains\Enum\Tag\TagStatusEnum;
use App\Models\Company;
use App\Models\Tag;
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
            'name' => ['required', new HumanNameRule()],
            'notes' => ['sometimes']
        ]);

        $tag = $this->tagRepository->createCompanyTag($company, $request->name, $request->notes);

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $tag);
    }

    public function update(Company $company, Tag $tag, Request $request)
    {
        $this->validate($request, [
            'name' => ['sometimes', new HumanNameRule()],
            'status' => ['sometimes', Rule::in(TagStatusEnum::values())],
            'notes' => ['sometimes']
        ]);

        $tag = $this->tagRepository->updateById($tag->id, [
            'name' => $request->name,
            'status' => $request->status ?? $tag->status,
        ]);

        return $this->response(Response::HTTP_CREATED, __('messages.record-updated'), $tag);
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
}
