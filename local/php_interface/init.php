<?
Bitrix\Main\Loader::includeModule("iblock");


function fillnews()
{
    $url = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';
    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    $xml = simplexml_load_string($data);


    $x = 0;

    foreach ($xml->channel->item as $item) {
        $x++;
        $date = substr($item->pubDate, 5, 11);
        $datebeg = date("d.m.Y", strtotime($date));

        $el = new CIBlockElement;
        $PROP = array();
        $PROP[1] = $item->author;
        $PROP[4] = $item->link;
        $file = CFile::MakeFileArray($item->enclosure->attributes()->url);

        $arLoadProductArray = Array(
            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "IBLOCK_ID" => 1,
            "ACTIVE_FROM" => $datebeg,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => $item->title,
            "ACTIVE" => "Y",            // активен
            "PREVIEW_TEXT" => $item->description,
            "DETAIL_TEXT" => $item->description,
            "PREVIEW_PICTURE" => $file,
            "DETAIL_PICTURE" => $file
        );

        $el->Add($arLoadProductArray);

        /*print '<li><a href = ‘{$item->link}’ title = ‘$item->title’>' .
            $item->title . '</a> - ' . $item->description . $item->pubDate . $item->link . '</li>';

        foreach ($item->enclosure as $enc) {
            print $enc->attributes()->url;
        }*/


        if ($x > 5) {
            return "fillnews()";
        }

    }
}
