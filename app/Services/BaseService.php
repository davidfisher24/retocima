<?php

namespace App\Services;

class BaseService 
{
	/**
    * Adds a ranking parameter to the collection of items
    * 
    * @param collection $collection (must be previously ordered)
    *
    * @return collection with $ranking added
    */
	
	protected function addRankingParameter($collection,$countField)
	{	
		$lastItem = null;
		$currentRank = 1;
		$rank = 1;
		foreach($collection as $item){
		   if ($item->$countField === $lastItem) {
		   		$item->ranking = $currentRank;
		   }
     	   else {
     	   		$currentRank = $rank;
     	   		$item->ranking = $rank;
     	   }
     	   $lastItem = $item->$countField;
		   $rank = $rank + 1;
		}
		return $collection;
	}
}

?>