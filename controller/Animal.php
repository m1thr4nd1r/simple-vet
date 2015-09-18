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
		$this->model->redefine(-1,$name,$species,$this->change_date($birth,"/"),$notes,$owner);

		$sql = 'INSERT INTO animal (name,species,birth,notes,owner) VALUES (:name,:species,:birth,:notes,:owner)';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':name' => $this->model->getName(),
							 ':species' => $this->model->getSpecies(),
							 ':birth' => $this->model->getBirth(),
							 ':notes' => $this->model->getNotes(),
							 ':owner' => $this->model->getOwner()));
		$this->show();
	}

	function update($id, $name, $species, $birth, $notes, $owner)
	{
		$this->model->redefine($id,$name,$species,$this->change_date($birth,"/"),$notes,$owner);

		$sql = 'UPDATE animal SET name=:name,species=:species,birth=:birth,notes=:notes,owner=:owner WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':id' => $this->model->getId(),
							 ':name' => $this->model->getName(),
							 ':species' => $this->model->getSpecies(),
							 ':birth' => $this->model->getBirth(),
							 ':notes' => $this->model->getNotes(),
							 ':owner' => $this->model->getOwner()));
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
    	$this->selectById($id);
    	$owners = $this->selectAllOwners();

		echo $this->twig->render('Animal/edit.html', array (
				'animal' => $this->model,
				'owners' => $owners
			));
    }

    function change_date($date,$separator)
	{
		$data = explode($separator,$date);
		$newDate = ($separator == "-")? $data[2]."/".$data[1]."/".$data[0] : $data[2]."-".$data[1]."-".$data[0];
		return $newDate;
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
		$sql = 'SELECT id,name, species, DATE_FORMAT(birth,:args) as birth, notes,`owner` FROM animal WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(
			':args' => "%d/%c/%Y",
			':id' => $id));
		$temp = $sth->fetch();
		$this->model->redefine($temp['id'],$temp['name'],$temp['species'],$temp['birth'],$temp['notes'],$temp['owner']);
	}

	function selectAll()
	{
		$list = null;
		$sql = 'SELECT id,name, species, DATE_FORMAT(birth,:args) as birth, notes,`owner` FROM animal';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(
			'args' => "%d/%c/%Y"));

		foreach ($sth->fetchAll() as $animal) {
			$list[] = $animal;
		};
		return $list;
	}
}