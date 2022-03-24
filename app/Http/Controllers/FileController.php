<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

/**
 * Manage the File System and the Storage,
 * mainly used to handle `.dat` files.
 *
 * @author Mestre-Tramador
 */
class FileController extends Controller
{
    /**
     * Base Path to the Storage.
     *
     * If empty, it points to root folder.
     *
     * @var string
     */
    protected readonly string $base_path;

    /**
     * File System to access files and folders.
     *
     * @var Filesystem
     */
    private Filesystem $storage;

    /**
     * The Controller can only be created by child ones,
     * due to access specific Base Paths.
     *
     * If not provided any Base Path, the root is used.
     *
     * @param string $base_path
     */
    protected function __construct(string $base_path = '')
    {
        $this->storage = Storage::disk('local');
        $this->base_path = $base_path;
    }

    /**
     * Get the contents of a file on the current **Base Path**.
     *
     * The file extension must be included.
     *
     * @param string $file
     * @return string|array|null
     */
    protected function get(string $file): string|array|null
    {
        return $this->storage->get($this->base_path.$file);
    }

    /**
     * Get the contents of a series of files.
     *
     * All the results are derived from the `get` method.
     *
     * @param string ...$files
     * @return array
     */
    protected function getAll(string ...$files): array
    {
        return array_map('self::get', $files);
    }

    /**
     * Put the given contents into the file on the path.
     *
     * If the file does not exist, then it's created.
     *
     * @param string $file
     * @param string|array $data
     * @return boolean
     * @final
     */
    final protected function set(string $file, string|array $data): bool
    {
        if($this->get($file) === null)
        {
            $this->create($file);
        }

        if(is_array($data))
        {
            $data = implode('\n', $data);
        }

        return $this->storage->put($file, $data);
    }

    /**
     * Create a file with blank data.
     *
     * @param string $file
     * @return boolean
     * @final
     */
    final protected function create(string $file): bool
    {
        if($this->get($file))
        {
            return true;
        }

        return $this->storage->put($file, '');
    }

    /**
     * Get all files on the **Base Path**.
     *
     * @return array
     * @final
     */
    final protected function folder(): array
    {
        $folder = $this->storage->allFiles($this->base_path);

        $folder = array_filter($folder, function($path) {
            $path = explode('/', $path);
            $path = end($path);

            return ($path[0] != '.');
        });

        return $folder;
    }
}
