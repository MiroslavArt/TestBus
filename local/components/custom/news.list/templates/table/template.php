<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<table width="100%" cellspacing="0" cellpadding="5" border="1">
    <tr style="text-align: left">
        <th>Название</th>
        <th>Доходы общие (млн. руб.)</th>
        <th>Расходы общие (млн. руб.)</th>
        <th>Количество жителей (чел.)</th>
        <th>Место в рейтинге по количеству жителей</th>
        <th>Место в рейтинге по средним доходам населения</th>
        <th>Место по средним расходам населения</th>
    </tr>
<?foreach($arResult["ITEMS"] as $arItem):?>
<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<td><?echo $arItem["NAME"]?></td>
    <td><?echo $arItem["DISPLAY_PROPERTIES"]["all_income"]["VALUE"] / 100000000 ?></td>
    <td><?echo $arItem["DISPLAY_PROPERTIES"]["all_cost"]["VALUE"] / 100000000 ?></td>
    <td><?echo $arItem["DISPLAY_PROPERTIES"]["all_citizens"]["VALUE"]?></td>
    <td><?echo $arItem["citizens_rating"]?></td>
    <td><?echo $arItem["av_income_rating"]?></td>
    <td><?echo $arItem["av_exp_rating"]?></td>
</tr>
<?endforeach;?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
