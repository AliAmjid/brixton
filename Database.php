<?php

class Database {

	private $username = 'root';
	private $password = 'root';
	private $host = 'localhost';
	private $database = 'brixton';

	private $conn;

	public function __construct() {
		if ($this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database)) {

		} else {
			throw new Exception();
		}
	}

	public function query($query) {
		return mysqli_query($this->conn, $query);
	}

	public function saveData($item, $data) {
		$this->validateVar($item);
		$this->validateVar($data);
		$this->query("INSERT INTO `list` (`item`, `data`, `last_update`) VALUES ('$item','$data', now());");
	}

	public function updateItem($id, $data) {
		$this->validateVar($id);
		$this->validateVar($data);
		$this->query("UPDATE `list` SET
`id` = $id
`data` = $data,
`last_update` = now()
WHERE `id` = '1';");
	}

	public function getItem($item) {
		$this->validateVar($item);
		return mysqli_fetch_assoc($this->query('SELECT * FROM list WHERE item = "' . $item . '"'));
	}

	private function validateVar(&$var) {
		$var = mysqli_real_escape_string($this->conn,$var);
	}
}