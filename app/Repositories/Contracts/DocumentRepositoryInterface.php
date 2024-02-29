<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateDocumentDTO;
use App\Domains\DTO\UpdateDocumentDTO;
use App\Models\Company;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\UploadedFile;

interface DocumentRepositoryInterface
{
    public function createDocument(CreateDocumentDTO $dto, UploadedFile $file);

    public function getCompanyDocuments(Company $company);

    public function getDocument(string|Document $document);

    public function updateDocument(string|Document $document, UpdateDocumentDTO $dto);

    public function deleteDocument(string|Document $document);

    public function changeDocumentFile(string|Document $document, UploadedFile $file);

    public function createDocumentType(Company $company, string $name);

    public function getCompanyDocumentType(Company $company);

    public function addAssetsToDocument(Document $document, array $assetIds);
}
