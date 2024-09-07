<?php

namespace App\Services;

use App\DTO\Sale\CreateNewSaleDTO;
use App\Http\Requests\StoreUpdateSaleRequest;
use League\Csv\Reader;

class ImportFile
{
    public function __construct(
        protected string $filePath
    ) {
    }

    public function processFile(): array
    {
        try {
            $csv = Reader::createFromPath($this->filePath, 'r');
        } catch (\Exception $e) {
            return ['errors' => ['File error' => $e->getMessage()], 'data' => []];
        }

        $errors = [];
        $data = [];
        $lineNumber = 1;

        foreach ($csv as $record) {
            $lineNumber++;

            // Cria o FormRequest e preenche com os dados do CSV
            $request = new StoreUpdateSaleRequest();
            $request->merge($record);

            // Valida os dados
            $recordValidar = $request->getValidatorInstance();

            if ($recordValidar->fails()) {
                $errors[$lineNumber] = $recordValidar->errors()->all();
                continue;
            }

            // Cria o DTO com os dados validados
            $saleDTO = CreateNewSaleDTO::makeFromRequest($request);

            // Adiciona o DTO ao array de dados
            $data[] = $saleDTO;
        }

        return ['errors' => $errors, 'data' => $data];
    }

}
