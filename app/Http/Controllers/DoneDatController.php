<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Manage and handle all `.done.dat` files.
 *
 * @author Mestre-Tramador
 * @final
 */
final class DoneDatController extends DatController
{
    /**
     * Key for the **Dump**'s Client Count.
     *
     * @var string
     */
    public const DUMP_CLIENT_COUNT = 0;

    /**
     * Key for the **Dump**'s Seller Count.
     *
     * @var string
     */
    public const DUMP_SELLER_COUNT = 1;

    /**
     * Key for the **Dump**'s Best Buy.
     *
     * @var string
     */
    public const DUMP_BEST_BUY = 2;

    /**
     * Key for the **Dump**'s Worst Seller.
     *
     * @var string
     */
    public const DUMP_WORST_SELLER = 3;

    /**
     * The **Dump** reserved file name.
     *
     * @var string
     */
    private const DUMP_FILE = 'dump';

    /**
     * The complementar extension of the files.
     *
     * @var string
     */
    private const PRE_EXT = '.done';

    /**
     * All treated `.done.dat` file are under the `out/` folder.
     *
     * An alternative **Base Path** can be passed.
     *
     * @param string $base_path
     */
    public function __construct(string $base_path = 'out/')
    {
        parent::__construct($base_path);
    }

    /**
     * Append the `.done` extension to a file name.
     *
     * @param string $name
     * @return string
     * @static
     */
    private static function makeDoneDat(string $name): string
    {
        return ($name . self::PRE_EXT);
    }

    /**
     * Create a `dump.done` file name.
     *
     * @return string
     * @static
     */
    private static function makeDumpDat(): string
    {
        return self::makeDoneDat(self::DUMP_FILE);
    }

    /**
     * Get the current dumped data, basically the result of the
     * most recent read of a `.dat` file.
     *
     * The JSON returned follows the pattern:
     *
     * ```json
     * [
     *  "integer",
     *  "integer",
     *  "string|null",
     *  "string|null"
     * ]
     * ```
     *
     * @return JsonResponse
     */
    public function getDump(): JsonResponse
    {
        $file = self::makeDumpDat();

        if(($dump = parent::get($file)) === null)
        {
            parent::create($this->base_path.parent::makeDat($file));

            return self::getDump();
        }

        // TODO: Use DatDump Model
        // TODO: Generate JSON Schemas

        $res = [
            self::DUMP_CLIENT_COUNT => 0,
            self::DUMP_SELLER_COUNT => 0,
            self::DUMP_BEST_BUY     => null,
            self::DUMP_WORST_SELLER => null
        ];

        if(!empty($dump) && count($dump) === 4)
        {
            $res[self::DUMP_CLIENT_COUNT] = (int) $dump[self::DUMP_CLIENT_COUNT];
            $res[self::DUMP_SELLER_COUNT] = (int) $dump[self::DUMP_SELLER_COUNT];
            $res[self::DUMP_BEST_BUY]     = $dump[self::DUMP_BEST_BUY];
            $res[self::DUMP_WORST_SELLER] = $dump[self::DUMP_WORST_SELLER];
        }

        return response()->json($res);
    }
}
