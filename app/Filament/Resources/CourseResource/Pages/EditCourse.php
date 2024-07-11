<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['is_live_course'] = !empty($data['is_live_course']) ? 1 : 0;
        $data['allow_course_complete'] = !empty($data['allow_course_complete']) ? 1 : 0;
        $data['copy_from_existing_course'] = !empty($data['copy_from_existing_course']) ? 1 : 0;
        $data['course_unenrolling'] = !empty($data['course_unenrolling']) ? 1 : 0;
        $data['content_access_after_completion'] = !empty($data['content_access_after_completion']) ? 1 : 0;
        return $data;
    }
}
