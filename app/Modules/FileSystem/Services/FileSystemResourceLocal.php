<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 12:12 PM
 */

namespace App\Modules\FileSystem\Services;

use App\Modules\FileSystem\Contracts\FileSystemResourceContract;
use App\Modules\FileSystem\Events\MakeResizedImagesEvent;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Storage;
use RuntimeException;
use StdClass;

/**
 * Class FileSystemResourceLocal
 * @package App\Modules\FileSystem\Services
 * @property $disk
 */
class FileSystemResourceLocal implements FileSystemResourceContract
{
    /**
     * @var
     */
    private $disk;

    /**
     * Return specific file
     *
     * @param Request $request
     * @param $folder
     * @param $fileName
     * @return mixed
     * @throws FileNotFoundException
     * @internal param $bucket
     */
    public function get(Request $request, $folder, $fileName)
    {
        // Set our storage disk, for S3 implementation of this file
        // We will pass here bucket name
        $this->setDisk();

        $path = '/' . $folder . '/' .$fileName;

        // If our file does not exist, exit
        if(!$this->disk->exists($path))  {
            throw new FileNotFoundException("File does not exist");
        }

        // Set headers
        $headers['Content-Type'] = $this->disk->mimeType($path);

        // ... and if we are downloading file, set as attachment
        if($request->download){
            $headers['Content-Disposition'] = "attachment; filename={$fileName}";
        }

        // ... then return response back to controller
        return response($this->disk->get($path))->withHeaders($headers);
    }

    /**
     * Store file
     *
     * @param Request $request
     * @param $folder
     * @param $fileName
     * @return mixed
     * @internal param $bucket
     */
    public function put(Request $request, $folder, $fileName)
    {
        // If file is not valid or uploaded, exit
        if (!$request->hasFile('body') || !$request->file('body')->isValid()) {
            throw new RuntimeException("File not uploaded, or is not valid");
        }

        // Set storage disk...
        $this->setDisk();

        $path = '/' . $folder . '/' .$fileName;

        // ... store file
        $this->disk->put($path, fopen($request->file('body'), 'r+'));

        // ... and if file is image
        // fire event to make smaller versions
        if(strpos($request->file('body')->getMimeType(), "image") !== false)  {
            $data = new StdClass();
            $data->file = $request->file('body');
            // in path for example 1/1.jpg, our folder will be image_id
            $data->image_id = $folder;
            $data->filename = $fileName;
            event(new MakeResizedImagesEvent($data));
        }
    }

    /**
     * Get storage disk
     *
     * @param string $bucket
     * @return mixed
     */
    public function setDisk($bucket = '')
    {
        $this->disk = Storage::disk('public');
    }
}