<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;

class UploadController extends ApiController
{
    protected $manager;

    public function __construct()
    {
        parent::__construct();

        $this->manager = app('uploader');
    }

    /**
     * Response the folder info.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->manager->folderInfo($request->get('folder'));

        return $this->response->json(['data' => $data]);
    }

    /**
     * Upload the file for file manager.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadForManager(Request $request)
    {
        $file = $request->file('file');

        $fileName = $request->get('name')
                    ? $request->get('name').'.'.explode('/', $file->getClientMimeType())[1]
                    : $file->getClientOriginalName();

        $path = str_finish($request->get('folder'), '/');

        if ($this->manager->checkFile($path.$fileName)) {
            return $this->response->withBadRequest('This File exists.');
        }

        $result = $this->manager->store($file, $path, $fileName);

        return $this->response->json($result);
    }

    /**
     * Generic file upload method.
     *
     * @param ImageRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileUpload(ImageRequest $request)
    {
        $strategy = $request->get('strategy', 'images');

        if (!$request->hasFile('image')) {
            return $this->response->json([
                'success' => false,
                'error' => 'no file found.',
            ]);
        }

        $path = $strategy.'/'.date('Y').'/'.date('m').'/'.date('d');

        $result = $this->manager->store($request->file('image'), $path);

        return $this->response->json($result);
    }

    /**
     * Create the folder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFolder(Request $request)
    {
        $folder = $request->get('folder');

        $data = $this->manager->createFolder($folder);

        return $this->response->json(['data' => $data]);
    }

    /**
     * Delete the folder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');

        $folder = $request->get('folder').'/'.$del_folder;

        $data = $this->manager->deleteFolder($folder);

        if (!$data) {
            return $this->response->withForbidden('The directory must be empty to delete it.');
        }

        return $this->response->json(['data' => $data]);
    }

    /**
     * Delete the file.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile(Request $request)
    {
        $path = $request->get('path');

        $data = $this->manager->deleteFile($path);

        return $this->response->json(['data' => $data]);
    }
}
