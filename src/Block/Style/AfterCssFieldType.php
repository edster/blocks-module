<?php namespace Anomaly\BlocksModule\Block\Style;

use Anomaly\BlocksModule\Block\Traits\ProvidesStyle;
use Anomaly\EditorFieldType\EditorFieldType;

/**
 * Class AfterCssFieldType
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AfterCssFieldType extends EditorFieldType
{

    use ProvidesStyle;

    /**
     * The field type label.
     *
     * @var string
     */
    protected $label = 'anomaly.module.blocks::style.after_css.label';

    /**
     * Get the configuration.
     *
     * @return array
     */
    public function getConfig()
    {
        $config = parent::getConfig();

        $config['mode'] = 'css';

        return $config;
    }

}
