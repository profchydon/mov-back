<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\EditDocumentRequest;
use App\Models\Company;
use App\Models\Document;
use App\Repositories\Contracts\DocumentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function destroy(Company $company, Document $document, Request $request)
    {
        $this->documentRepository->deleteDocument($document);

        return $this->noContent();
    }
}
