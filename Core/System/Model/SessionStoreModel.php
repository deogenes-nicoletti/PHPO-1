<?php
	namespace Core\System\Model;

	use Core\System\GenericClassSystem;

	final class SessionStoreModel extends GenericClassSystem
	{
		private $boolSerialize;
		private $absData;

		public function __construct($boolSerialize, $absData)
		{
			$this->boolSerialize = $boolSerialize;

			if($this->boolSerialize)
				$this->absData = $this->FileHelper()->serializa($absData);
			else
				$this->absData = $absData;
		}

		public function getData(){
			return $this->boolSerialize == true ? $this->FileHelper()->deserializa($this->absData) : $this->absData;
		}

		public function isSerialized()
		{
			return $this->boolSerialize;
		}
	}