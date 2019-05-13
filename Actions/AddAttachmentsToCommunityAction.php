<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Community\Models\Community;
use App\Containers\Media\UI\API\Requests\CreateMediaRequest;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Storage;
use App\Containers\Media\Exceptions\CouldNotUploadFileException;

/**
 * Class AddAttachmentsToCommunityAction
 * @package App\Containers\Community\Actions
 */
class AddAttachmentsToCommunityAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        $data = $request->sanitizeInput([
            'type',
            'file',
        ]);

        $data['entity_id'] = Hashids::encode($request->id);
        $data['entity_type'] = Community::class;

        $media = Apiato::call('Media@FindMediaByEntityIdAndTypeTask', [$request->type, $request->id, Community::class]);

        if ($media && $media->id) {
            $data['entity_id'] = $request->id;
            if ($media->file) {
                try {
                    Storage::delete($media->file);
                } catch (\Exception $exception) {}
            }

            $file = Storage::put('public/media', $request->file);

            if (!$file) {
                throw new CouldNotUploadFileException();
            }
            $data['file'] = $file;

            $media = Apiato::call('Media@UpdateMediaTask', [$media->id, $data]);

            return $media;
        }

        return Apiato::call('Media@CreateMediaAction', [new CreateMediaRequest($data)]);
    }
}
