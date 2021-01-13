<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


/*TAGS*/
if ($arParams["SEARCH_PAGE"])
{
	if ($arResult["FIELDS"] && isset($arResult["FIELDS"]["TAGS"]))
	{
		$tags = array();
		foreach (explode(",", $arResult["FIELDS"]["TAGS"]) as $tag)
		{
			$tag = trim($tag, " \t\n\r");
			if ($tag)
			{
				$url = CHTTP::urlAddParams(
					$arParams["SEARCH_PAGE"],
					array(
						"tags" => $tag,
					),
					array(
						"encode" => true,
					)
				);
				$tags[] = '<a href="'.$url.'">'.$tag.'</a>';
			}
		}
		$arResult["FIELDS"]["TAGS"] = implode(", ", $tags);
	}
}
/*VIDEO & AUDIO*/
$mediaProperty = trim($arParams["MEDIA_PROPERTY"]);
if ($mediaProperty)
{
	if (is_numeric($mediaProperty))
	{
		$propertyFilter = array(
			"ID" => $mediaProperty,
		);
	}
	else
	{
		$propertyFilter = array(
			"CODE" => $mediaProperty,
		);
	}

	$elementIndex = array();
	$elementIndex[$arResult["ID"]] = array(
		"PROPERTIES" => array(),
	);

	CIBlockElement::GetPropertyValuesArray($elementIndex, $arResult["IBLOCK_ID"], array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ID" => $arResult["ID"],
	), $propertyFilter);

	foreach ($elementIndex as $idx)
	{
		foreach ($idx["PROPERTIES"] as $property)
		{
			$url = '';
			if ($property["MULTIPLE"] == "Y" && $property["VALUE"])
			{
				$url = current($property["VALUE"]);
			}
			if ($property["MULTIPLE"] == "N" && $property["VALUE"])
			{
				$url = $property["VALUE"];
			}

			if (preg_match('/(?:youtube\\.com|youtu\\.be).*?[\\?\\&]v=([^\\?\\&]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'https://www.youtube.com/embed/'.$matches[1].'/?rel=0&controls=0showinfo=0';
			}
			elseif (preg_match('/(?:vimeo\\.com)\\/([0-9]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'https://player.vimeo.com/video/'.$matches[1];
			}
			elseif (preg_match('/(?:rutube\\.ru).*?\\/video\\/([0-9a-f]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'http://rutube.ru/video/embed/'.$matches[1].'?sTitle=false&sAuthor=false';
			}
			elseif (preg_match('/(?:soundcloud\\.com)/i', $url, $matches))
			{
				$arResult["SOUND_CLOUD"] = $url;
			}
		}
	}
}

/*SLIDER*/
$sliderProperty = trim($arParams["SLIDER_PROPERTY"]);
if ($sliderProperty)
{
	if (is_numeric($sliderProperty))
	{
		$propertyFilter = array(
			"ID" => $sliderProperty,
		);
	}
	else
	{
		$propertyFilter = array(
			"CODE" => $sliderProperty,
		);
	}

	$elementIndex = array();
	$elementIndex[$arResult["ID"]] = array(
		"PROPERTIES" => array(),
	);

	CIBlockElement::GetPropertyValuesArray($elementIndex, $arResult["IBLOCK_ID"], array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ID" => $arResult["ID"],
	), $propertyFilter);

	foreach ($elementIndex as $idx)
	{
		foreach ($idx["PROPERTIES"] as $property)
		{
			$files = array();
			if ($property["MULTIPLE"] == "Y" && $property["VALUE"])
			{
				$files = $property["VALUE"];
			}
			if ($property["MULTIPLE"] == "N" && $property["VALUE"])
			{
				$files = array($property["VALUE"]);
			}

			if ($files)
			{
				$arResult["SLIDER"] = array();
				foreach ($files as $fileId)
				{
					$file = CFile::GetFileArray($fileId);
					if ($file && $file["WIDTH"] > 0 && $file["HEIGHT"] > 0)
					{
						$arResult["SLIDER"][] = $file;
					}
				}
			}
		}
	}
}

// счетчик просмотров
$id = $arResult['ID'];
$ip = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();
$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_news" => $id, "PROPERTY_ip" => $ip);
$res =  CIBlockElement::GetList(Array(), $arFilter, false, false)->Fetch();
CIBlockElement::GetPropertyValuesArray($elementIndex, 1, array(
    "IBLOCK_ID" => 1,
    "ID" => $id,
));

$visitors = $elementIndex[$id]['visitors']['VALUE'];
$author = $elementIndex[$id]['author']['VALUE'];
$urllink = $elementIndex[$id]['urllink']['VALUE'];
$datepub = $elementIndex[$id]['datetimepub']['VALUE'];
$datepub = date("d.m.Y H:i:s", strtotime($datepub));

if(!$res){
    $el = new CIBlockElement;
    $PROP = array();
    $PROP[5] = $id;
    $PROP[8] = $ip;
    $arLoadProductArray = Array(
        "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID"      => 3,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $ip,
        "ACTIVE"         => "Y"          // активен
    );
    $el->Add($arLoadProductArray);

    $visitors++;

    $elnews = new CIBlockElement;
    $PROPNEWS = array();
    $PROPNEWS[1] = $author;
    $PROPNEWS[4] = $urllink;
    $PROPNEWS[7] = $visitors;
    $PROPNEWS[9] = $datepub;
    $arLoadProductArrayNews = Array(
        "PROPERTY_VALUES"=> $PROPNEWS
    );
    $elnews->Update($id, $arLoadProductArrayNews);
}

$arResult['DISPLAY_PROPERTIES']['author'] = $author;
$arResult['DISPLAY_PROPERTIES']['urllink'] = $urllink;
$arResult['DISPLAY_PROPERTIES']['visitors'] = $visitors;






