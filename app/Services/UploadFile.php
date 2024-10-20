<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class UploadFile
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = 's3'; // Define o disco padrão como S3
    }

    /**
     * Armazena um ficheiro no caminho especificado no S3.
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string
     * @throws Exception
     */
    public function store(UploadedFile $file, string $path): string
    {
        try {
            return $file->store($path, 's3');
        } catch (Exception $e) {
            throw new Exception('Erro ao armazenar o ficheiro: ' . $e->getMessage());
        }
    }

    /**
     * Armazena um ficheiro no caminho especificado com um nome personalizado no S3.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string $customName
     * @return string
     * @throws Exception
     */
    public function storeAs(UploadedFile $file, string $path, string $customName): string
    {
        try {
            return $file->storeAs($path, $customName, 's3');
        } catch (Exception $e) {
            throw new Exception('Erro ao armazenar o ficheiro com nome personalizado: ' . $e->getMessage());
        }
    }

    /**
     * Remove um ficheiro do caminho especificado no S3.
     *
     * @param string $filePath
     * @return bool
     * @throws Exception
     */
    public function removeFile(string $filePath): bool
    {
        try {
            if (Storage::disk('s3')->exists($filePath)) {
                return Storage::disk('s3')->delete($filePath);
            } else {
                throw new Exception("Ficheiro não encontrado no S3: $filePath");
            }
        } catch (Exception $e) {
            throw new Exception('Erro ao remover o ficheiro: ' . $e->getMessage());
        }
    }

    /**
     * Função auxiliar para lidar com o upload e verificar se o ficheiro foi armazenado corretamente.
     *
     * @param callable $uploadFunction
     * @return string
     * @throws Exception
     */
    protected function handleUpload(callable $uploadFunction): string
    {
        try {
            $storedPath = $uploadFunction();

            // Verifica se o ficheiro foi realmente guardado
            if (!Storage::disk($this->disk)->exists($storedPath)) {
                throw new Exception('Erro: Ficheiro não encontrado após o upload.');
            }

            return $storedPath;
        } catch (Exception $e) {
            throw new Exception('Erro ao armazenar o ficheiro: ' . $e->getMessage());
        }
    }
}
