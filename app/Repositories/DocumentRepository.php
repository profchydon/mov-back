<?php

namespace App\Repositories;

use App\Domains\DTO\CreateDocumentDTO;
use App\Domains\DTO\UpdateDocumentDTO;
use App\Models\Company;
use App\Models\Document;
use App\Repositories\Contracts\DocumentRepositoryInterface;
use Aws\S3\S3Client;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        $fileName = sprintf('%s/%s/%s.%s', "company_documents", $document->company_id, $document->id, $document->generateFileName($file->getClientOriginalExtension()));

        $url = Storage::disk('s3')->putFileAs(config('filesystems.base-folder'), $file->getRealPath(), $fileName);

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

        $document = $document->load(['file', 'uploader']);

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

        $url = Storage::disk('s3')->putFileAs(config('filesystems.base-folder'), $file->getRealPath(), $document->generateFileName($file->getClientOriginalExtension()));

        $document->file()->update(['path' => $url]);

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
}
