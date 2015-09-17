<?php 

class AnimalModel
{
	private $id,$name,$species,$birth,$notes,$owner;

	public function __construct()
	{
		$this->id = -1;
		$this->name = '';
		$this->species = '';
		$this->birth = '';
		$this->notes = '';
		$this->owner = '';
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getSpecies()
	{
		return $this->species;
	}

	public function getBirth()
	{
		return $this->birth;
	}

	public function getNotes()
	{
		return $this->notes;
	}

	public function getOwner()
	{
		return $this->owner;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setSpecies($species)
	{
		$this->species = $species;
	}

	public function setBirth($birth)
	{
		$this->birth = $birth;	
	}

	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function setOwner($owner)
	{
		$this->owner = $owner;
	}
}