<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\EditDocumentRequest;
use App\Models\Company;
use App\Models\Document;
use App\Models\DocumentType;
use App\Repositories\Contracts\DocumentRepositoryInterface;
use App\Rules\HumanNameRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{
    public function __construct(private readonly DocumentRepositoryInterface $documentRepository)
    {
    }

    public function index(Company $company)
    {
        $documents = $this->documentRepository->getCompanyDocuments($company);

        return $this->response(Response::HTTP_OK, __("messages.records-fetched"), $documents);
    }

    public function show(Company $company, Document $document)
    {
        $document = $this->documentRepository->getDocument($document);

        return $this->response(Response::HTTP_OK, __("messages.record-fetched"), $document);
    }

    public function store(Company $company, CreateDocumentRequest $request)
    {
        $document = $this->documentRepository->createDocument($request->getDTO(), $request->file('file'));

        return $this->response(Response::HTTP_CREATED, __("messages.record-created"), $document);
    }

    public function update(Company $company, Document $document, EditDocumentRequest $request)
    {
        $document = $this->documentRepository->updateDocument($document, $request->getDTO());

        return $this->response(Response::HTTP_OK, __("messages.record-updated"), $document);
    }

    public function changeFile(Company $company, Document $document, Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);

        $document = $this->documentRepository->changeDocumentFile($document, $request->file('file'));

        return $this->response(Response::HTTP_OK, __("messages.record-updated"), $document);
    }

    public function createDocumentType(Company $company, Request $request)
    {
        $request->name = Str::lower($request->name);
        $this->validate($request, [
            'name' => [new HumanNameRule(), Rule::unique('document_types', 'name')->where('company_id', $company->id)]
        ]);

        $documentType = $this->documentRepository->createDocumentType($company, $request->name);

        return $this->response(Response::HTTP_CREATED, __("messages.record-created"), $documentType);
    }

    public function addAssets(Company $company, Document $document, Request $request)
    {
        $this->validate($request, [
            'asset_ids' => 'required|array|min:1',
            'asset_ids.*' => [Rule::exists('assets', 'id')->where('company_id', $company->id), Rule::unique('asset_documents', 'asset_id')->where('document_id', $document->id)]
        ]);

        $document = $this->documentRepository->addAssetsToDocument($document, $request->asset_ids);

        return $this->response(Response::HTTP_CREATED, __("messages.record-created"), $document);
    }

    public function getDocumentType(Company $company)
    {
        $type = $this->documentRepository->getCompanyDocumentType($company);

        return $this->response(Response::HTTP_OK, __("messages.record-updated"), $type);
    }

    public function deleteDocumentType(Company $company, DocumentType $type)
    {
        $type->delete();

        return $this->noContent();
    }

    public function destroy(Company $company, Document $document, Request $request)
    {
        $this->documentRepository->deleteDocument($document);

        return $this->noContent();
    }
}
