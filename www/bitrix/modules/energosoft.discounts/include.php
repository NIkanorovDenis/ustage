<?
namespace Energosoft\Discounts;

class DiscountsHelper
{
	public static function OnProlog()
	{

	}

	public static function Search($array, $key, $value)
	{
		$results = array();
		if(is_array($array))
		{
			if(isset($array[$key]) && $array[$key] == $value) $results[] = $array;
			foreach($array as $subarray) $results = array_merge($results, self::Search($subarray, $key, $value));
		}
		return $results;
	}
}
?>