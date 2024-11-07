<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $data =  [
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ];

        if(isset($this->files)){
            $data['files.*'] = 'required|file';
        }

        return $data;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Преобразуем FileBag в массив файлов
            $files = $this->file('files'); // Используем метод 'file' для получения файлов

            $totalSize = 0;

            foreach ($files as $file) {
                // Проверяем, что $file — это объект UploadedFile
                if ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                    $totalSize += $file->getSize(); // Получаем размер файла
                }
            }

            $maxTotalSize = 50 * 1024 * 1024; // 50 MB

            if ($totalSize > $maxTotalSize) {
                $validator->errors()->add('files', "Բոլոր ֆայլերի ընդհանուր չափը չպետք է գերազանցի 50 մեգաբայթ:");
            }
        });
    }

}
