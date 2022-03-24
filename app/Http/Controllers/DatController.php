<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Manage and handle all `.dat` files.
 *
 * @author Mestre-Tramador
 */
class DatController extends FileController
{
    /**
     * The extension of the files.
     *
     * @var string
     */
    protected const EXT = '.dat';

    /**
     * The `.dat` file lines are encrypted
     * and must be separated by a specific character.
     *
     * @var string
     */
    protected const SEPARATOR = 'ç';

    /**
     * All untreated `.dat` file are under the `in/` folder.
     *
     * An alternative **Base Path** can be passed.
     *
     * @param string $base_path
     */
    public function __construct(string $base_path = 'in/')
    {
        parent::__construct($base_path);
    }

    /**
     * Append the `.dat` extension to a file name.
     *
     * @param string $name
     * @return string
     * @final
     * @static
     */
    final protected static function makeDat(string $name): string
    {
        return ($name . self::EXT);
    }

    /**
     * Count all current stored `.dat` files under the **Base Path**.
     *
     * The JSON has only one property, *count*, which is the number.
     *
     * Below is an example:
     *
     * ```json
     * { "count": 2 }
     * ```
     *
     * @return JsonResponse
     * @final
     */
    final public function countDats(): JsonResponse
    {
        return response()->json(['count' => count(parent::folder())]);
    }

    /**
     * Get the file contents and treat it, breaking each line and
     * separating its data.
     *
     * Only the name of the `.dat` file is needed.
     *
     * @param string $file
     * @return string|array|null
     */
    final protected function get(string $file): string|array|null
    {
        if(!empty($data = parent::get(self::makeDat($file))))
        {
            $data = array_filter(preg_split("/\r\n|\n|\r/", $data));

            $data = array_map(
                fn($info) => (strpos($info, self::SEPARATOR) ? explode(self::SEPARATOR, $info) : $info),
                $data
            );

            return $data;
        }

        return $file;
    }

    /**
     * Instead of simply getting the file contents, it also treat them.
     *
     * @param string ...$files
     * @return array
     */
    final protected function getAll(string ...$files): array
    {
        return array_map('self::get', $files);
    }
}
