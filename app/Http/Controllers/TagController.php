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
        ]);

        $tag = $this->tagRepository->createCompanyTag($company, $request->name);

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $tag);
    }

    public function update(Company $company, Tag $tag, Request $request)
    {
        $this->validate($request, [
            'name' => ['sometimes', new HumanNameRule()],
            'status' => ['sometimes', Rule::in(TagStatusEnum::values())],
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
}
