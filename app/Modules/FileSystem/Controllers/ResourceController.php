<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 11:12 AM
 */

namespace App\Modules\FileSystem\Controllers;

use App\Common\Controllers\ApiController;
use App\Modules\FileSystem\Contracts\FileSystemResourceContract;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use RuntimeException;
use Exception;

/**
 * Class ResourceController
 * @package App\Modules\FileSystem\Controllers
 * @property FileSystemResourceContract $fileSystem
 */
class ResourceController extends ApiController
{
    /**
     * @var FileSystemResourceContract
     */
    private $fileSystem;

    /**
     * ResourceController constructor.
     * @param FileSystemResourceContract $fileSystem
     */
    public function __construct(FileSystemResourceContract $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function show(Request $request, $folderName, $fileName)
    {
        try {
            return $this->fileSystem->get($request, $folderName, $fileName);
        }catch(FileNotFoundException $e){
            return $this->notOk([], $e->getMessage(), 404);
        }catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }

    public function store(Request $request, $folderName, $fileName)
    {
        try {

            $this->fileSystem->put($request, $folderName, $fileName);

        } catch (RuntimeException $e) {
            return $this->notOk([], $e->getMessage(),400);
        } catch(Exception $e){
            return $this->notOk([], $e->getMessage(),500);
        }
    }
}