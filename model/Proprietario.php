<?php 

class ProprietarioModel
{
	private $name,$email,$phone,$address;

	public function __construct()
	{
		$this->id = -1;
		$this->name = '';
		$this->email = '';
		$this->phone = '';
		$this->address = '';
	}

	public function getName()
	{
		return $this->name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function setName($name)
	{
		$this->name = $name	
	}

	public function setEmail($email)
	{
		$this->email = $email	
	}

	public function setPhone($phone)
	{
		$this->phone = $phone	
	}

	public function setAddress($address)
	{
		$this->address = $address	
	}
}