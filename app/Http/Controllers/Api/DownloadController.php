<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function downloadLessonPdf($file)
    {
        try {
            $lessonModule = Lesson::findOrFail($file);

            if ($lessonModule->file) {

                return Storage::download($lessonModule->file);

            } else {
                return response()->json(['error' => 'Arquivo não encontrado'], 404);
            }
        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => 'Lição não encontrada'], 404);

        } catch (FileNotFoundException $e) {

            return response()->json(['error' => 'Arquivo não encontrado'], 404);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Erro ao baixar o arquivo'], 500);
        }
    }
}
