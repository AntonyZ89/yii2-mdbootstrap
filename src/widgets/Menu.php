<?php

namespace antonyz89\mdb\widgets;

use antonyz89\mdb\helpers\Html;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Menu as MenuBase;

/**
 * Class Menu
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class Menu extends MenuBase
{
    public $submenuTemplate = '<ul class="collapse list-group list-group-flush shadow-2-soft bg-white border active {class}" id="{id}">{items}</ul>';

    /**
     * Renders the menu.
     */
    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $items = $this->normalizeItems($this->items, $hasActiveChild);
        if (!empty($items)) {
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'nav');

            echo Html::tag(
                $tag,
                Html::tag(
                    'div',
                    Html::tag(
                        'div',
                        $this->renderItems($items),
                        'list-group list-group-flush mx-3 mt-4'
                    ),
                    'position-sticky'
                ),
                $options
            );
        }
    }

    /**
     * Renders the main menu
     */
    protected function renderMenu()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = $_GET;
        }
        $items = $this->normalizeItems($this->items, $hasActiveChild);
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'nav');

        return Html::tag(
            $tag,
            Html::tag(
                'div',
                Html::tag(
                    'div',
                    $this->renderItems($items),
                    'list-group list-group-flush mx-3 mt-4'
                ),
                'position-sticky'
            ),
            $options
        );
    }

    /**
     * @param array $items
     * @param string|null $id
     * @return string
     * @throws Exception
     */
    protected function renderItems($items)
    {
        $items = array_map(function ($item) {
            $id = !empty($item['items']) ? preg_replace("/^\d+/", '',  Yii::$app->security->generateRandomString(10)) : null;

            $menu = $this->renderItem($item, $id);

            if (!empty($item['items'])) {
                $this->normalizeItems($item['items'], $hasActiveChild);

                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $submenuTemplate = str_replace(['{id}', '{class}'], [$id, $hasActiveChild ? 'show' : null], $submenuTemplate);
                $submenu = str_replace('{items}', $this->renderItems($item['items']), $submenuTemplate);
                $menu = str_replace('{items}', $submenu, $menu);
            } else {
                $menu = str_replace('{items}', '', $menu);
            }
            return $menu;
        }, $items);

        return implode("\n", $items);
    }

    /**
     * @inheritdoc
     */
    protected function renderItem($item, $id = null)
    {
        if (isset($item['items'])) {
            $linkTemplate =
                Html::a([
                    '{icon}',
                    '{label}',
                    Html::icon('chevron-down'),
                ], '{url}', [
                    'class' => 'list-group-item list-group-item-action py-2 ripple {class}',
                    'data-mdb-toggle' => 'collapse',
                    'aria' => [
                        'current' => 'true',
                        'expanded' => 'false',
                        'controls' => $id
                    ],
                    '{linkOptions}'
                ]) . '{items}';
        } else {
            $linkTemplate = Html::a([
                '{icon}',
                '{label}'
            ], '{url}', [
                'class' => 'list-group-item list-group-item-action {class}',
                '{linkOptions}'
            ]);
        }

        $linkTemplate = preg_replace("/\d=\"([^\"]+)\"/", '$1', $linkTemplate);

        $linkOptions = [];
        $class = [];
        if ($item['active']) {
            $linkOptions[] = "aria-current='true'";
            $class[] = $this->activeCssClass;
        }

        if (isset($item['linkOptions'])) {
            foreach ($item['linkOptions'] as $key => $value) {
                $linkOptions[] = "$key=\"$value\"";
            }
        }

        $replacements = [
            '{linkOptions}' => implode(' ', $linkOptions),
            '{class}' => implode(' ', $class),
            '{label}' => $item['label'],
            '{icon}' => empty($item['icon']) ? '' : Html::icon($item['icon'], 'fa-fw me-3'),
            '{url}' => isset($item['url']) ? Url::to($item['url']) : ($id ? "#$id" : 'javascript:void(0);')
        ];

        $template = ArrayHelper::getValue($item, 'template', $linkTemplate);

        return strtr($template, $replacements);
    }
}
