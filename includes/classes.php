<?php
class User{
	public $db; 		
	public $url; 		
	public $UID; 		
	public $Name; 		
	public $Phone; 
	public $Email;
	public $Gender;
	public $Age;
	
	function newUser(){
		if ($this->verifyUser()==0){
			$query = sprintf("INSERT INTO `users` (`UID`,`Name`,`Age`,`Email`,`Phone`,`Gender`) VALUES ('%s','%s','%s','%s','%s','%s')",$this->db->real_escape_string($this->UID),$this->db->real_escape_string($this->Name),$this->db->real_escape_string($this->Age),$this->db->real_escape_string($this->Email),$this->db->real_escape_string($this->Phone),$this->db->real_escape_string($this->Gender));
			$this->db->query($query);
		}else
			$this->updateUser();
	}
	function updateUser(){
		$query = sprintf("UPDATE `users` SET `Name` = '%s', `Age` = '%s', `Email` = '%s', `Phone` = '%s', `Gender` = '%s' WHERE `UID` = '%s'",$this->db->real_escape_string($this->Name),$this->db->real_escape_string($this->Age),$this->db->real_escape_string($this->Email),$this->db->real_escape_string($this->Phone),$this->db->real_escape_string($this->Gender),$this->db->real_escape_string($this->UID));
		$this->db->query($query);
	}
	function verifyUser(){
		$query = sprintf("SELECT `UID` FROM `users` WHERE `UID`='%s'",$this->db->real_escape_string($this->UID));
		$result=$this->db->query($query);
		return ($result->num_rows == 0) ? 0 : 1;
	}
	function getUsers(){
		$query = sprintf("SELECT * FROM `users`");
		$result=$this->db->query($query);
		if($result->num_rows == 0){
			return notificationBox('info','There is no users yet on the database');
		}else{
			$output='<table class="table table-striped">
			  <thead>
				<tr>
				  <th scope="col">UID</th>
				  <th scope="col">Name</th>
				  <th scope="col">Age</th>
				  <th scope="col">Email</th>
				  <th scope="col">Phone</th>
				  <th scope="col">Gender</th>
				</tr>
			  </thead>
			  <tbody>';
			while($row = $result->fetch_assoc()) {
				$output.= '<tr>
				  <th scope="col">'.$row['UID'].'</td>
				  <td scope="col">'.$row['Name'].'</td>
				  <td scope="col">'.$row['Age'].'</td>
				  <td scope="col">'.$row['Email'].'</td>
				  <td scope="col">'.$row['Phone'].'</td>
				  <td scope="col">'.$row['Gender'].'</td>
				</tr>';
			}
			$output.='</tbody></table>';
			return $output;
		}
	}
	function clearRecords() {
		$query = sprintf("TRUNCATE TABLE  `users`");
		$this->db->query($query);
	}
}

class Csvfile {
	public $filename;
	private $fileheader = array ('UID','Name','Age','Email','Phone','Gender');
	
	function import($db) {
		if($this->verifyFile()==0){
			$row=1;
			if (($handle = fopen("./uploads/".$this->filename, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					if ($row>=2) {
						$user = new User();
						$user->db=$db;
						$user->UID=$data[0];
						$user->Name=$data[1];
						$user->Age=$data[2];
						$user->Email=$data[3];
						$user->Phone=$data[4];
						$user->Gender=$data[5];
						$user->newUser();
					}
					$row++;
				}
				fclose($handle);
			}
			return notificationBox('success','File imported successfuly');
		}else
			return notificationBox('danger','header dont macth');
	}
	
	function verifyFile(){
		if (($handle = fopen("./uploads/".$this->filename, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				if($num ==6) {
					for ($c=0; $c < $num; $c++) {
						if($data[$c] != $this->fileheader[$c]){
							echo 'fh '.$data[$c].' cfh '.$this->fileheader[$c];
							$x=1;
							break;
						}
					}
				}else 
					$x=1;
				break;
			}
			fclose($handle);
		}
		if ($x!=0)
			return 1;
		else
			return 0;
	}
}
function notificationBox ($type, $msg) {
	return  '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
				'.$msg.'
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>';
}

?>