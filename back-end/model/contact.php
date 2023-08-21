<?php
	class Contact {
		private $id;
		private $userId;
		private $name;
		private $email;
		private $phone;
		private $photo;

		public function __construct($pId, $pUserId, $pName, $pEmail, $pphone, $pPhoto) {
			$this->id = $pId;
      $this->userId = $pUserId;
			$this->name = $pName;
			$this->email = $pEmail;
			$this->phone = $pphone;
			$this->photo = $pPhoto;
		}

		public function get($attr) {
			switch($attr) {
				case 'id':
				return $this->id;
				break;

        case 'userId':
        return $this->userId;
        break;

				case 'name':
				return $this->name;
				break;

				case 'email':
				return $this->email;
				break;

				case 'phone':
				return $this->phone;
				break;

				case 'photo':
				return $this->phone;
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

        case 'userId':
        $this->userId = $value;
        break;

				case 'name':
				$this->name = $value;
				break;

				case 'email':
				$this->email = $value;
				break;

				case 'phone':
				$this->phone = $value;
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
			."<b>userId:</b> $this->userId<br>"
			."<b>name:</b> $this->name<br>"
			."<b>email:</b> $this->email<br>"
			."<b>phone:</b> $this->phone<br>"
			."<b>photo:</b> $this->photo<br>";
		}
	}
?>