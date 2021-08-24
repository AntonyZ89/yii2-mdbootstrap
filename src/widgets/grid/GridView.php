<?php

namespace antonyz89\mdb\widgets\grid;

use antonyz89\pagesize\PageSize;
use antonyz89\mdb\helpers\Html;
use kartik\grid\GridView as GridViewBase;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class GridView
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class GridView extends GridViewBase
{
    public $bordered = false;
    public $striped = false;
    public $options = ['class' => 'grid-view border'];

    /*********************/

    public $panelFooterTemplate = '{footer}<div class="clearfix"></div>';
    public $filterSelector = '#per-page';

    public $selectable = false; // TODO add checkbox to rows
    public $drawer;

    /*********************/

    public function init()
    {
        self::$bsCssMap[self::BS_PULL_RIGHT] = ['pull-right', 'float-end'];

        parent::init();
    }

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    protected function initPanel()
    {
        $this->panel['heading'] = ArrayHelper::getValue($this->panel, 'heading', false);
        $this->panel['before'] = ArrayHelper::getValue($this->panel, 'before', false);
        $this->panel['after'] = ArrayHelper::getValue($this->panel, 'after', false);

        $pageSize = PageSize::widget([
            'options' => [
                'id' => str_replace('#', '', $this->filterSelector)
            ]
        ]);

        $defaultFooter = "
<div class='row justify-content-end'>
    <div class='col-auto'>
        Resultados por página <!-- TODO use i18n -->
    </div>
    <div style='width: 150px'>$pageSize</div>
    <div class='col-auto'>{pager}</div>
    <span class='col-12'>{summary}</span>
</div>";

        $this->panel['footer'] = ArrayHelper::getValue($this->panel, 'footer') ?? $defaultFooter;

        parent::initPanel();
    }

    protected function renderToolbar()
    {
        if ($this->drawer !== null) {
            $this->toolbar[] = [
                'content' => Html::tag(
                    'div',
                    Html::icon('filter'),
                    [
                        'class' => 'btn btn-link btn-light',
                        'type' => "button",
                        'data-mdb-toggle' => "collapse",
                        'data-mdb-target' => '#' . $this->drawer,
                        'aria-controls' => "sidebarMenu",
                        'aria-expanded' => "false",
                        'aria-label' => "Toggle navigation",
                    ]
                )
            ];
        }


        return parent::renderToolbar();
    }

    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkPager */
        $pager = $this->pager;

        $class = ArrayHelper::remove($pager, 'class', LinkPager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();

        return $class::widget($pager);
    }
}