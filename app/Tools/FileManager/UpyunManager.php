<?php

namespace App\Tools\FileManager;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpyunManager extends BaseManager
{
    /**
     * Get all the files by the folder.
     * 
     * @param  string $folder
     * @return array
     */
    public function getFileList($path)
    {
        $files = [];

        $filesContent = $this->disk->listContents($path);

        foreach ($filesContent as $file) {
            $files[] = $this->fileDetail($file);
        }

        return $files;
    }

    /**
     * Get the file detail by the path.
     *
     * @param $path
     * @return array
     */
    public function fileDetail($file)
    {
        $path = $file['path'];

        return [
            'name' => $file['basename'],
            'fullPath' => $path,
            'webPath'  => $this->fileWebPath($path),
            'mimeType' => $this->fileMimeType($path),
            'size'     => $this->fileSize($path),
            'type'     => $file['type'],
            'modified' => $this->fileModified($path)
        ];
    }

    /**
     * Get the file's webpath by the path.
     *
     * @param $path
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function fileWebPath($path)
    {
        return $this->disk->getUrl($path);
    }

    /**
     * Get the file's mime type by the path.
     *
     * @param $path
     * @return mixed|null|string
     */
    public function fileMimeType($path)
    {
        return $this->disk->getMimetype($path);
    }

    /**
     * Get the file's size by the path.
     *
     * @param $path
     * @return mixed
     */
    public function fileSize($path)
    {
        return human_filesize($this->disk->getSize($path));
    }

    /**
     * Get the file's last modified time by the path.
     *
     * @param $path
     * @return string
     */
    public function fileModified($path)
    {
        return Carbon::createFromTimestamp(
            substr($this->disk->getTimestamp($path), 0, 10)
        )->toDateTimeString();
    }

    /**
     * Create a new folder.
     *
     * @param $folder
     * @return string
     */
    public function createFolder($folder)
    {
        $this->cleanFolder($folder);

        if ($this->checkFolder($folder)) {
            throw new UploadException("The Folder exists.");
        }

        return $this->disk->createDir($folder);
    }

    /**
     * Handle the file upload.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param string                                              $dir
     * @param string                                              $name
     *
     * @return array|bool
     */
    public function store(UploadedFile $file, $dir = '', $name = '')
    {
        $hashName = empty($name)
                    ? str_ireplace('.jpeg', '.jpg', $file->hashName())
                    : $name;

        $mime = $file->getMimeType();

        $realPath = $this->disk->putFileAs($dir, $file, $hashName);

        return [
                'success' => true,
                'filename' => $hashName,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $mime,
                'size' => human_filesize($file->getClientSize()),
                'real_path' => $realPath,
                'relative_url' => $realPath,
                'url' => $this->disk->getUrl($realPath),
        ];
    }

    /**
     * Delete the folder.
     *
     * @param $folder
     * @return string
     */
    public function deleteFolder($folder)
    {
        $this->cleanFolder($folder);

        $filesFolders = array_merge(
            $this->disk->directories($folder),
            $this->disk->files($folder)
        );

        if (!empty($filesFolders)) {
            return false;
        }

        return $this->disk->deleteDir($folder);
    }
}