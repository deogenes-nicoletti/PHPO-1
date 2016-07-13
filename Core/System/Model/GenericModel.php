<?php
	namespace Core\System\Model;

	class GenericModel
	{
		public function toArray()
		{
			$arr = [];

			foreach (get_object_vars($this) as $key => $obj)
				$arr[$key] = $obj;

			return $arr;
		}
	}