<?php

use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>

<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php foreach ($models as $model) :?>
        <div class="task-card">
            <div class="header-task">
                <a  href="<?= Url::to(['/tasks/view/', 'id' => $model->id]) ;?>" class="link link--block link--big"><?= HTML::encode($model->title) ;?></a>
                <p class="price price--task"><?= $model->budget ;?> ₽</p>
            </div>
            <p class="info-text"><span class="current-time"><?= yii::$app->formatter->asRelativeTime($model->publication_dt) ;?></span></p>
            <p class="task-text">
                <?= HTML::encode($model->description) ;?>
            </p>
            <div class="footer-task">
                <?php if($model->city_id) :?>
                <p class="info-text town-text"><?= $model->city->name ;?></p>
                <?php endif ;?>
                <p class="info-text category-text"><?= $model->category->name ;?></p>
                <a href="<?= Url::to(['/tasks/view/', 'id' => $model->id]) ;?>" class="button button--black">Смотреть Задание</a>
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
                            <?=html::activeCheckboxList($tasks, 'category_id', array_column($categories, 'name', 'id'),
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
