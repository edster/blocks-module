<?php namespace Anomaly\BlocksModule\Block;

use Anomaly\BlocksModule\Block\Contract\BlockInterface;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Decorator;

/**
 * Class BlockPresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BlockPresenter extends EntryPresenter
{

    /**
     * The decorated object.
     *
     * @var BlockInterface
     */
    protected $object;

    /**
     * Catch calls to fields on
     * the page's related entry.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        $entry = $this->object->getEntry();

        if ($entry && $entry->hasField($key)) {
            return (New Decorator())->decorate($entry)->{$key};
        }

        return parent::__get($key);
    }
}