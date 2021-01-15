<?php
$navpgs = $arResult['NAV_RESULT']->NavPageSize;
$navpgc = $arResult['NAV_RESULT']->NavPageNomer - 1;

if($navpgc > 0) {
    $currentplace = $navpgc*$navpgs+1;
} else {
    $currentplace = 1;
}

$arFields = array('ID');
$ratingarray = array();

$arSelect = Array("ID", "PROPERTY_all_income", "PROPERTY_all_cost", "PROPERTY_all_citizens");
$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $ratingarray[$arFields['ID']]['av_income'] = round($arFields['PROPERTY_ALL_INCOME_VALUE'] / $arFields['PROPERTY_ALL_CITIZENS_VALUE']);
    $ratingarray[$arFields['ID']]['av_exp'] = round($arFields['PROPERTY_ALL_COST_VALUE'] / $arFields['PROPERTY_ALL_CITIZENS_VALUE']);
}

$ratingarrayavinc = $ratingarray;
$ratingarrayavexp = $ratingarray;

uasort ($ratingarrayavinc, 'av_income');

uasort ($ratingarrayavexp, 'av_exp');

$avinc_keys = array_keys($ratingarrayavinc);
$avexp_keys = array_keys($ratingarrayavexp);

foreach ($arResult['ITEMS'] as &$item) {
    $item['citizens_rating'] = $currentplace;
    $item['av_income_rating'] = array_search($item['ID'], $avinc_keys) + 1;
    $item['av_exp_rating'] = array_search($item['ID'], $avexp_keys) + 1;
    $currentplace++;
}

function av_income($x, $y) {
    if ($x['av_income'] < $y['av_income']) {
        return true;
    } else if ($x['av_income'] > $y['av_income']) {
        return false;
    } else {
        return 0;
    }

}

function av_exp($x, $y) {
    if ($x['av_exp'] < $y['av_exp']) {
        return true;
    } else if ($x['av_exp'] > $y['av_exp']) {
        return false;
    } else {
        return 0;
    }
}