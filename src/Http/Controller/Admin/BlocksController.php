<?php namespace Anomaly\BlocksModule\Http\Controller\Admin;

use Anomaly\BlocksModule\Area\Command\GetArea;
use Anomaly\BlocksModule\Area\Contract\AreaInterface;
use Anomaly\BlocksModule\Block\BlockExtension;
use Anomaly\BlocksModule\Block\Contract\BlockRepositoryInterface;
use Anomaly\BlocksModule\Block\Form\BlockAssemblyFormBuilder;
use Anomaly\BlocksModule\Block\Form\BlockFormBuilder;
use Anomaly\BlocksModule\Block\Table\BlockTableBuilder;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

/**
 * Class BlocksController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BlocksController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param BlockTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BlockTableBuilder $table, $area)
    {

        /* @var AreaInterface $area */
        if (!$area = $this->dispatch(new GetArea($area))) {
            abort(404);
        }

        $table->setArea($area);

        $table->setOption('title', $area->getTitle());
        $table->setOption('description', $area->getDescription());

        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param BlockAssemblyFormBuilder|BlockFormBuilder $form
     * @param BlockFormBuilder                          $default
     * @param ExtensionCollection                       $extensions
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(
        BlockAssemblyFormBuilder $form,
        BlockFormBuilder $block,
        ExtensionCollection $extensions,
        $area
    ) {

        /* @var BlockExtension $extension */
        if (!$extension = $extensions->get($this->request->get('extension'))) {
            abort(400, 'You must specify a block extension.');
        }

        $block->setExtension($extension);

        /* @var AreaInterface $area */
        if (!$area = $this->dispatch(new GetArea($area))) {
            abort(404);
        }

        $block->setArea($area);

        $form->addForm('block', $block);

        $extension->extend($form);

        return $form->render();
    }

    /**
     * Return a list of blocks to view.
     *
     * @param BlockRepositoryInterface $blocks
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function choose(ExtensionCollection $extensions)
    {
        return view(
            'anomaly.module.blocks::admin/blocks/choose',
            [
                'extensions' => $extensions
                    ->search('anomaly.module.blocks::block.*')
                    ->enabled()
                    ->all(),
            ]
        );
    }

    /**
     * Edit an existing entry.
     *
     * @param BlockFormBuilder $form
     * @param                  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(BlockFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}