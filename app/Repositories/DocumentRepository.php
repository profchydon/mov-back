<?php

namespace App\Repositories;

use App\Domains\DTO\CreateDocumentDTO;
use App\Domains\DTO\UpdateDocumentDTO;
use App\Models\Asset;
use App\Models\AssetDocument;
use App\Models\Company;
use App\Models\Document;
use App\Models\DocumentType;
use App\Repositories\Contracts\DocumentRepositoryInterface;
use Aws\S3\S3Client;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{
    public function model()
    {
        return Document::class;
    }

    public function createDocument(CreateDocumentDTO $dto, UploadedFile $file)
    {
        DB::beginTransaction();
        $document = Document::firstOrCreate($dto->toSynthensizedArray());

        $url = Storage::disk('s3')->putFileAs(config('filesystems.base-folder'), $file->getRealPath(), $document->generateFileName($file->getClientOriginalExtension()));

        $document->file()->create(['path' => $url]);
        DB::commit();

        return $document;
    }

    public function getCompanyDocuments(Company $company)
    {
        $documents = $company->documents();
        $documents = Document::appendToQueryFromRequestQueryParameters($documents);

        return $documents->paginate();
    }

    public function getDocument(string|Document $document)
    {
        if (!($document instanceof Document)) {
            $document = Document::findOrFail($document);
        }

        $document = $document->load(['file', 'uploader', 'history', 'assets']);

        $document->versions = $document->file->getVersionsAttribute();

        return $document;
    }

    public function updateDocument(string|Document $document, UpdateDocumentDTO $dto)
    {
        if (!($document instanceof Document)) {
            $document = Document::findOrFail($document);
        }

        $document->update($dto->toSynthensizedArray());

        return $document->fresh();
    }

    public function changeDocumentFile(string|Document $document, UploadedFile $file)
    {
        if (!($document instanceof Document)) {
            $document = Document::findOrFail($document);
        }

        if ($document->user_id !== Auth::id()) {
            return new AuthorizationException("You can't update a file you didn't upload");
        }

        $url = Storage::disk('s3')->putFileAs(config('filesystems.base-folder'), $file->getRealPath(), $document->generateFileName($file->getClientOriginalExtension()));

        $document->file()->update(['path' => $url]);

        $document->update([
            'version' => ++$document->version
        ]);

        Cache::delete($document->file->cacheKey());

        return $document->fresh();
    }

    public function deleteDocument(string|Document $document)
    {
        if (!($document instanceof Document)) {
            $document = Document::findOrFail($document);
        }

        Storage::disk('s3')->delete($document->file?->path);

        return $document->delete();
    }

    public function createDocumentType(Company $company, string $name)
    {
        return $company->documentTypes()->firstOrCreate(['name' => $name]);
    }

    public function getCompanyDocumentType(Company $company)
    {
        $type = DocumentType::whereNull('company_id')->orWhere('company_id', $company->id);
        $type = DocumentType::appendToQueryFromRequestQueryParameters($type);

        return $type->get();
    }

    public function addAssetsToDocument(Document $document, array $assetIds)
    {
        return collect($assetIds)->map(fn($id) => AssetDocument::create(['asset_id' => $id, 'document_id' => $document->id]));

        return $document->load('assets');
    }
}
