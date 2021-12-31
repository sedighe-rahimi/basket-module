<?php
namespace Modules\Basket\Facades;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class basket
 * @method static basket add(string $listName , array $value)
 * @method static bool has($id)
 * @method static Collection all();
 * @method static array get($id);
 */
class Basket extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'basket';
    }
}
