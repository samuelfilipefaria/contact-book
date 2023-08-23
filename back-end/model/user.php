<?php
	class User {
		private $id;
		private $name;
		private $email;
		private $password;
		private $photo;

		public function __construct($pId, $pName, $pEmail, $pPassword, $pPhoto) {
			$this->id = $pId;
			$this->name = $pName;
			$this->email = $pEmail;
			$this->password = $pPassword;
			$this->photo = $pPhoto;
		}

		public function get($attr) {
			switch($attr) {
				case 'id':
				return $this->id;
				break;

				case 'name':
				return $this->name;
				break;

				case 'email':
				return $this->email;
				break;

				case 'password':
				return $this->password;
				break;

				case 'photo':
				return $this->photo;
				break;

				default:
				return 'Atributo inválido!';
			}
		}

		public function set($attr, $value) {
			switch($attr) {
				case 'id':
				$this->id = $value;
				break;

				case 'name':
				$this->name = $value;
				break;

				case 'email':
				$this->email = $value;
				break;

				case 'password':
				$this->password = $value;
				break;

				case 'photo':
				$this->photo = $value;
				break;

				default:
				return 'Atributo inválido!';
			}
		}

		public function __toString() {
			return
			"<b>id:</b> $this->id<br>"
			."<b>name:</b> $this->name<br>"
			."<b>email:</b> $this->email<br>"
			."<b>password:</b> $this->password<br>"
			."<b>photo:</b> $this->photo<br>";
		}
	}

	// $p = new User(1, 'João', 'joao@123.com', 'senha123', 'foto');
?>