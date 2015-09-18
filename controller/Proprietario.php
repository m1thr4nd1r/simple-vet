<?php
include "~/../model/Proprietario.php";

class ProprietarioController
{
	private $model,$twig,$db;

	function __construct($twig,$db) {
        $this->model = new ProprietarioModel();
        $this->twig = $twig;
        $this->db = $db;
    }

    function add()
    {
    	echo $this->twig->render('Proprietario/create.html');
    }

	function create($name, $email, $phone, $address)
	{
		$this->model->redefine(-1,$name,$email,substr_replace($phone,'',-5,1),$address);

		$sql = 'INSERT INTO owner (name,email,phone,address) VALUES (:name,:email,:phone,:address)';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':name' => $this->model->getName(),
							 ':email' => $this->model->getEmail(),
							 ':phone' => $this->model->getPhone(),
							 ':address' => $this->model->getAddress()));
		$this->show();
	}

	function update($id, $name, $email, $phone, $address)
	{
		$this->model->redefine($id,$name,$email,substr_replace($phone,'',-5,1),$address);

		$sql = 'UPDATE owner SET name=:name,email=:email,phone=:phone,address=:address WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':id' => $this->model->getId(),
							 ':name' => $this->model->getName(),
							 ':email' => $this->model->getEmail(),
							 ':phone' => $this->model->getPhone(),
							 ':address' => $this->model->getAddress()));
		$this->show();
	}

	function delete($id)
	{
		$sql = 'DELETE FROM owner WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':id' => $id));
		$this->show();
	}

    function edit($id)
    {
    	$this->selectById($id);
    	$animals = $this->selectAnimalByOwner($id);
		echo $this->twig->render('Proprietario/edit.html', array (
				'owner' => $this->model,
				'animals' => $animals
			));
    }

	function show ()
	{
		$owners = $this->selectAll();
		echo $this->twig->render('Proprietario/list.html', array (
				'owners' => $owners
			));
	}

	function selectById($id)
	{
		$sql = 'SELECT * FROM owner WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':id' => $id));
		$temp = $sth->fetch();
		$this->model->redefine($temp['id'],$temp['name'],$temp['email'],substr_replace($temp['phone'],'-',-4,0),$temp['address']);
	}

	function selectAnimalByOwner($id)
	{
		$sql = 'SELECT id,name, species, DATE_FORMAT(birth,:args) as birth, notes,`owner` FROM animal WHERE owner = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(
			':args' => "%d/%c/%Y",
			':id' => $id));

		$list = null;
		foreach ($sth->fetchAll() as $animal) {
			$list[] = $animal;
		}
		return $list;
	}

	function selectAll()
	{
		$list = null;
		foreach ($this->db->query('SELECT * FROM owner') as $owner) {
		 	$owner['phone'] = substr_replace($owner['phone'],'-',-4,0);
		 	$list[] = $owner;		 	
		};
		return $list;
	}
}