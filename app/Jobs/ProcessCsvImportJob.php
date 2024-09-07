<?php

namespace App\Jobs;

use App\DTO\Sale\ImportCsvDTO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Services\SaleService;
use Illuminate\Support\Facades\Storage;

class ProcessCsvImportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(SaleService $saleService): void
    {
        $fullPath = storage_path('app/' . $this->filePath);

        // Verificar se o arquivo existe
        if (!Storage::exists($this->filePath)) {
            // Log ou lança uma exceção caso o arquivo não exista
            throw new \Exception("Arquivo não encontrado: {$fullPath}");
        }

        // Cria o Reader a partir do caminho do arquivo
        $csv = Reader::createFromPath($fullPath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $offset = 0;
        $limit = 100;

        while (true) {
            $stmt = (new Statement())->offset($offset)->limit($limit);
            $record = $stmt->process($csv);

            if (count($record) === 0) {
                break;
            }

            foreach ($record as $record) {
                $values = $record;
                $dto = ImportCsvDTO::makeFromArray($values);
                $saleService->csvImportMember($dto);
            }

            $offset += $limit;
        }

    }
}
