<?php

namespace antonyz89\mdb\widgets;

use antonyz89\templates\helpers\Html;
use Yii;
use yii\bootstrap4\Alert as BootstrapAlert;
use yii\bootstrap4\Widget;

class Alert extends Widget
{
    public $alertTypes;

    public $closeButton = [];

    public $isAjaxRemoveFlash = true;

    public function init()
    {
        parent::init();
        $this->initTypes();

        $session = Yii::$app->session;
        $flashes = $session->allFlashes;
        $appendCss = $this->options['class'] ?? null;

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;

                foreach ($data as $message) {
                    $this->options['class'] = $this->alertTypes[$type]['class'] . ' ' . $appendCss;
                    $this->options['id'] = $this->getId() . '-' . $type;

                    echo BootstrapAlert::widget([
                        'body' => $this->alertTypes[$type]['icon'] . $message,
                        'closeButton' => $this->closeButton,
                        'options' => $this->options,
                    ]);
                }

                if ($this->isAjaxRemoveFlash && !Yii::$app->request->isAjax) {
                    $session->removeFlash($type);
                }
            }
        }
    }

    public function initTypes()
    {
        $this->alertTypes = [
            'error' => [
                'class' => 'alert-danger',
                'icon' => Html::icon('bug'),
            ],
            'danger' => [
                'class' => 'alert-danger',
                'icon' => Html::icon('exclamation-circle'),
            ],
            'success' => [
                'class' => 'alert-success',
                'icon' => Html::icon('check-circle'),
            ],
            'info' => [
                'class' => 'alert-info',
                'icon' => Html::icon('info-circle'),
            ],
            'warning' => [
                'class' => 'alert-warning',
                'icon' => Html::icon('exclamation-triangle'),
            ],
        ];
    }
}
