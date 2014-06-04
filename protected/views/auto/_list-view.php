<?php
    if (!$search_empty)
        echo CHtml::link('', array('/auto/'), array(
            'class'=>'button_clear_search',
            'style'=>'margin-top: -32px;',
            'name'=>'clear_search'
        ));
?>

<?php if ($dataProvider->itemCount > 0): ?>

<table id="table_auto" class="announcements">
	<thead>
        <tr>
            <td class="photo" rel="1"><div>Фото</div></td>
            <td class="title" rel="2"><div>Название</div></td>
            <td class="cost" rel="5"><div>Стоимость, руб</div></td>
            <td class="year" rel="6"><div>Год выпуска</div></td>
            <td class="run" rel="7"><div>Пробег, км</div></td>
            <td class="date" rel="8"><div>Дата объявления</div></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($dataProvider->getData() as $item): ?>
        <tr>
            <td class="photo" rel="1">
                <div class="image">
                <a href="<?php echo $this->createUrl('auto/view', array('id'=>$item->auto_id, 'gorod'=>$item->user->city->translit)); ?>">
                <?= CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$item->gall->original[0]->ph_url)), '', array(
                    'width' => 100,
                    'height' => 80,
                )) ?>
                </a>
                </div>
            </td>
            <td rel="2">
                <?= CHtml::link($item->automodel->modelbrend->b_name.' '.$item->automodel->m_name, $this->createUrl('auto/view', array('id'=>$item->auto_id, 'gorod'=>$item->user->city->translit))) ?>
            </td>
            <td class="cost" rel="5">
                <span class="text_price"><?= Functions::priceFormat($item->auto_price) ?></span><div class="cost_rub"></div>
            </td>
            <td class="year" rel="6">
                <?= $item->auto_year ?>
            </td>
            <td class="run" rel="7">
                <?= Functions::priceFormat($item->auto_run) ?>
            </td>
            <td class="date" rel="8" class="date_public">
                <div style="float: left; font-style: italic; font-weight: bold;">
                    <?= Functions::when_it_was($item->auto_public_date, true) ?>
                </div>
                <a class="product_add"></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
//print_r($dataProvider->pagination);die();
$this->widget('application.components.CLinkPagerExt',array(
    'pages'=>$dataProvider->pagination,
    'cssFile'=>false,
    'header'=>'',
    'nextPageLabel'=>'',
    'prevPageLabel'=>'',
    'firstPageLabel'=>'',
    'lastPageLabel'=>'',
)); ?>

<?php else: ?>
    <div class="default-text" style="margin-left: 10px;">Не найдено объявлений</div>
<?php endif; ?>

