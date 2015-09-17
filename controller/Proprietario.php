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
		$this->model->setName($name);
		$this->model->setEmail($email);
		$this->model->setPhone($phone);
		$this->model->setAddress($address);

		$sql = 'INSERT INTO owner (name,email,phone,address) VALUES (:name,:email,:phone,:address)';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':name' => $name,
							 ':email' => $email,
							 ':phone' => $phone,
							 ':address' => $address));
		$this->show();
	}

	function update($id, $name, $email, $phone, $address)
	{
		$this->model->setId($id);
		$this->model->setName($name);
		$this->model->setEmail($email);
		$this->model->setPhone($phone);
		$this->model->setAddress($address);

		$sql = 'UPDATE owner SET name=:name,email=:email,phone=:phone,address=:address WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute( array(':id' => $id,
							 ':name' => $name,
							 ':email' => $email,
							 ':phone' => $phone,
							 ':address' => $address));
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
    	$owner = $this->selectById($id);
		echo $this->twig->render('Proprietario/edit.html', array (
				'owner' => $owner
			));
    }

	function show ()
	{
		$owners = $this->selectall();
		echo $this->twig->render('Proprietario/list.html', array (
				'owners' => $owners
			));
	}

	function selectById($id)
	{
		$sql = 'SELECT * FROM owner WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':id' => $id));
		return $sth->fetch();
	}

	function selectall()
	{
		$list = null;
		foreach ($this->db->query('SELECT * FROM owner') as $owner) {
		 	$list[] = $owner;
		};
		return $list;
	}
}