<?php


namespace antonyz89\mdb\widgets\grid;

use antonyz89\templates\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager as LinkPagerBase;

/**
 * Class LinkPager
 * @package antonyz89\mdb\widgets
 */
class LinkPager extends LinkPagerBase
{
    protected function getPageRange()
    {
        return [0, 0];
    }

    public function run()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $currentPage = $this->pagination->getPage();

        $html = [
            Html::tag(
                $currentPage > 0 ? 'a' : 'button',
                Html::icon('chevron-left'),
                [
                    'class' => 'btn btn-sm shadow-0' . ($currentPage > 0 ? null : ' disabled'),
                    'data-page' => $currentPage - 1,
                    'data-mdb-ripple-color' => 'dark',
                    'href' => $this->pagination->createUrl($currentPage - 1)
                ]
            ),
            Html::tag(
                $currentPage < $pageCount - 1 ? 'a' : 'button',
                Html::icon('chevron-right'),
                [
                    'class' => 'btn btn-sm shadow-0' . ($currentPage < $pageCount - 1 ? null : ' disabled'),
                    'data-mdb-ripple-color' => 'dark',
                    'data-page' => $currentPage + 1,
                    'href' => $this->pagination->createUrl($currentPage + 1)
                ]
            )
        ];

        return implode("\n", array_flatten($html)); // TODO extract flatten from functions.php
    }

    /**
     * @inheritDoc
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();


        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        [$beginPage, $endPage] = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, $this->disableCurrentPageButton && $i == $currentPage, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');


        return Html::tag($tag, implode("\n", $buttons), $options);
    }

    /**
     * @inheritDoc
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $disabledItemOptions = $this->disabledListItemSubTagOptions;
            $tag = ArrayHelper::remove($disabledItemOptions, 'tag', 'span');

            return Html::tag($linkWrapTag, Html::tag($tag, $label, $disabledItemOptions), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag($linkWrapTag, Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}
