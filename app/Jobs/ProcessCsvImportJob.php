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
use Illuminate\Support\Facades\Log;

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
        $dataFile = ['course_id', 'name', 'email_student', 'date_expired', 'product_type'];
        $csv = Reader::createFromPath($this->filePath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $csv->setEscape('');

        $offset = 0;
        $limit = 100; // Limite por bloco

        $sales = [];

        while (true) {
            $stmt = (new Statement())->offset($offset)->limit($limit);
            $records = $stmt->process($csv);

            if (count($records) === 0) {
                break;
            }

            foreach ($records as $record) {
                $values = array_combine($dataFile, $record);

                if ($values === false) {
                    Log::error('Erro ao mapear valores do CSV. Verifique o arquivo e tente novamente.');
                    return;
                }

                $dto = ImportCsvDTO::makeFromArray($values);
                $sales[] = $saleService->csvImportMember($dto);
            }

            $offset += $limit;
        }

        // Aqui você pode fazer outras ações, como registrar que a importação foi concluída.
        Log::info('Vendas importadas com sucesso!', ['sales' => $sales]);
    }

}
