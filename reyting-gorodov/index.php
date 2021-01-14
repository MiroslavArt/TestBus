<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рейтинг городов");
?>
<p><?$APPLICATION->IncludeComponent(
    "custom:news.list",
    "table",
    Array(
        "IBLOCK_TYPE" => "vacancies",
        "IBLOCK_ID" => "4",
        "NEWS_COUNT" => "20",

        "SORT_BY1" => "PROPERTY_all_citizens",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "ID",
        "SORT_ORDER2" => "ASC",

        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",

        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" =>"d.m.Y",
        "SET_TITLE" => "N",
        "SET_BROWSER_TITLE" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_META_DESCRIPTION" => "Y",
        "MESSAGE_404" => "Страница не найдена или у вас нет прав на ее просмотр",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" =>  "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",

        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "INCLUDE_SUBSECTIONS" => "Y",

        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",

        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Города",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
        "PAGER_SHOW_ALL" => "N",

        "USE_RATING" => "N",
        "DISPLAY_AS_RATING" => "N",

        "USE_SHARE" => "N",

        "PROPERTY_CODE" => array('all_income', 'all_cost', 'all_citizens')

    )
    );?></p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
