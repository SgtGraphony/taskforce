<?php

use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>

<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php foreach ($models as $model) :?>
        <div class="task-card">
            <div class="header-task">
                <a  href="#" class="link link--block link--big"><?= HTML::encode($model->TITLE) ;?></a>
                <p class="price price--task"><?= $model->BUDGET ;?> ₽</p>
            </div>
            <p class="info-text"><span class="current-time"><?= yii::$app->formatter->asRelativeTime($model->PUBLICATION_DATE) ;?></span></p>
            <p class="task-text">
                <?= HTML::encode($model->DESCRIPTION) ;?>
            </p>
            <div class="footer-task">
                <?php if($model->CITY_ID) :?>
                <p class="info-text town-text"><?= $model->cITY->CITY ;?></p>
                <?php endif ;?>
                <p class="info-text category-text"><?= $model->cATEGORY->CATEGORY ;?></p>
                <a href="#" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
        <?php endforeach ;?>

        <div class="pagination-wrapper">

        <?= LinkPager::widget([
            'pagination' => $pages,
            'hideOnSinglePage' => true,
        ]) ;?>
            <!-- <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>

                <li class="pagination-item pagination-item--active">
                    <a href="#" class="link link--page"></a>
                </li>

                </li>
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
            </ul> -->
        </div>
    </div>
    <div class="right-column">
       <div class="right-card black">
           <div class="search-form">
                <?php $form = ActiveForm::begin() ;?>
                    <h4 class="head-card">Категории</h4>
                    <div class="form-group">
                        <div class="checkbox-wrapper">
                            <?=html::activeCheckboxList($tasks, 'CATEGORY_ID', array_column($categories, 'CATEGORY', 'ID'),
                            ['tag' => null, 'itemOptions' => ['labelOptions' => ['class' => 'control-label']]]) ;?>
                        </div>
                    </div>
                    <h4 class="head-card">Дополнительно</h4>
                    <div class="form-group">
                        <?= $form->field($tasks, 'noResponses')->checkbox(['labelOptions' => ['class' => 'control-label']]) ;?>
                        <?= $form->field($tasks, 'noLocation')->checkbox(['labelOptions' => ['class' => 'control-label']]) ;?>
                    </div>
                    <h4 class="head-card">Период</h4>
                    <div class="form-group">
                        <?= $form->field($tasks, 'filterPeriod', ['template' => '{input}'])->dropDownList([
                            '' => 'Выбрать', '3600' => 'За последний час' , '86400' => 'За сутки', '604800' => 'За неделю'
                        ], ['promt' => 'Выбрать']) ;?>
                    </div>
                    <input type="submit" class="button button--blue" value="Искать">
                <?php $form = ActiveForm::end() ;?>
           </div>
       </div>
    </div>
</main>
