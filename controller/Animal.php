<?php
include "~/../model/Animal.php";

class AnimalController
{
	private $model,$twig,$db;

	function __construct($twig,$db) {
        $this->model = new AnimalModel();
        $this->twig = $twig;
        $this->db = $db;
    }

    function add()
    {
    	$owners = $this->selectAllOwners();
    	echo $this->twig->render('Animal/create.html', array( 'owners' => $owners ));
    }

	function create($name, $species, $birth, $notes, $owner)
	{
		$this->model->setName($name);
		$this->model->setSpecies($species);
		$this->model->setBirth($birth);
		$this->model->setNotes($notes);
		$this->model->setOwner($owner);

		$sql = 'INSERT INTO animal (name,species,birth,notes,owner) VALUES (:name,:species,:birth,:notes,:owner)';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':name' => $name,
							 ':species' => $species,
							 ':birth' => $birth,
							 ':notes' => $notes,
							 ':owner' => $owner));
		$this->show();
	}

	function update($id, $name, $species, $birth, $notes, $owner)
	{
		$this->model->setId($id);
		$this->model->setName($name);
		$this->model->setSpecies($species);
		$this->model->setBirth($birth);
		$this->model->setNotes($notes);
		$this->model->setOwner($owner);

		$sql = 'UPDATE animal SET name=:name,species=:species,birth=:birth,notes=:notes,owner=:owner WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':id' => $id,
							 ':name' => $name,
							 ':species' => $species,
							 ':birth' => $birth,
							 ':notes' => $notes,
							 ':owner' => $owner));
		$this->show();
	}

	function delete($id)
	{
		$sql = 'DELETE FROM animal WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':id' => $id));
		$this->show();
	}

    function edit($id)
    {
    	$animal = $this->selectById($id);
    	$owners = $this->selectAllOwners();
		echo $this->twig->render('Animal/edit.html', array (
				'animal' => $animal,
				'owners' => $owners
			));
    }

	function show ()
	{
		$animals = $this->selectAll();
		echo $this->twig->render('Animal/list.html', array (
				'animals' => $animals
			));
	}

	function selectAllOwners()
	{
		$list = null;
		foreach ($this->db->query('SELECT * FROM owner') as $owner) {
		 	$list[] = $owner;
		};
		return $list;
	}

	function selectById($id)
	{
		$sql = 'SELECT * FROM animal WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':id' => $id));
		return $sth->fetch();
	}

	function selectAll()
	{
		$list = null;
		foreach ($this->db->query('SELECT * FROM animal') as $animal) {
		 	$list[] = $animal;
		};
		return $list;
	}
}