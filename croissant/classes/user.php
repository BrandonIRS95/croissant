<?php	
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('typeusers.php');
	
	class User extends Connection
	{
		//attribute
		private $id;		
		private $nickname;
		private $password;
		private $first_name;		
		private $last_name;
		private $email;
		private $image;
		private $type;
        private $status;
		
		//methods
		public function get_id() { return $this->id;}
		public function set_id($value) { $this->id = $value; }			
		public function get_nickname() { return $this->nickname; }
		public function set_nickname($value) { $this->nickname = $value; }
		public function get_email() { return $this->email; }
		public function set_email($value) { $this->email = $value; }
		public function get_image() { return $this->image; }
		public function set_image($value) { $this->image = $value; }
		public function get_first_name() { return $this->first_name; }
		public function set_first_name($value) { $this->first_name = $value; } 	
		public function get_last_name() { return $this->last_name; }
		public function set_last_name($value) { $this->last_name = $value; }
		public function get_type() { return $this->type;}
		public function set_type($value) { $this->type = $value; }	
		public function set_password($value) { $this->password = $value; } 
        public function get_status() { return $this->status; }
		public function set_status($value) { $this->status = $value; }
		
		//Constructor
		function __construct()
		{
			//if no arguments received, create a new empty object
			if(func_num_args() == 0)
			{
				$this->id = 0;				
				$this->nickname = '';
				$this->first_name = '';				
				$this->last_name = '';	
				$this->email = '';	
				$this->image = '';					
				$this->type = New Type();
                $this->status = 0;
			}			
			//if one argument received create object with data
			if(func_num_args() == 1)
			{				
				//receive arguments into an array
				$args = func_get_args();
				//id
				$id = $args[0];
				//open connection to MySQL
				parent::open_connection();
				//query
				$query = "select Use_Id, use_status, Use_Nickname, Use_FirstName, Use_LastName, Use_email, use_Image, Type_Id from users where Use_Id= ?";
				//prepare command
				$command = parent::$connection ->prepare($query);
				//link parameters
				$command ->bind_param('i', $id);//estaba en i 
				//execute command				
				$command -> execute();
				//link results to class attributes
				$command -> bind_result($this -> id,  $this->status, $this->nickname, $this -> first_name, $this->last_name, $this->email, $this->image, $type); 
				//fetch data 					
				$found = $command -> fetch();
				//close command 
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if($found)					
					$this->type = new Type($type);
				else
					throw(new RecordNotFoundException());
			}
			if(func_num_args() == 2)
			{				
				//receive arguments into an array
				$args = func_get_args();
				//id
				$email = $args[0];
				$password = $args[1];				
				//open connection to MySQL
				parent::open_connection();
				//query
				$query = "select Use_Id, use_status, Use_Image,Use_Nickname, Use_FirstName, Use_LastName, Type_Id from users where Use_Email = ? and Use_Password = sha1(?)";
				//prepare command
				$command = parent::$connection ->prepare($query);
				//link parameters
				$command ->bind_param('ss', $email, $password); 
				//execute command				
				$command -> execute();
				//link results to class attributes
				$command -> bind_result($this ->id, $this->status, $this->image ,$this->nickname, $this ->first_name, $this->last_name, $type); 
				//fetch data 					
				$found = $command -> fetch();
				//close command 
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if($found)					
					$this->type = new Type($type);
				else
					throw(new RecordNotFoundException());
			}
		}
		public function Add()
		{
			parent::open_connection();				
			$query = "insert into users(Use_Id, Use_Email, Use_Image, Use_FirstName, Use_LastName, Use_Nickname, Use_Password, Type_Id, Use_Status) values (null, ?, ?, ?, ?, ?, sha1(?), ?, 0)";				
			$command = parent::$connection->prepare($query);
			$command->bind_param('ssssssi', $this->email, $this->image, $this->first_name, $this->last_name, $this->nickname, $this->password, $this->type->get_id());				
			$added = $command->execute();
			$id = $command->insert_id;
			$this->id = $id;
			mysqli_stmt_close($command);				
			parent::close_connection();				
			return $added;
		}
		public function Deleted()
		{
			parent::open_connection();				
			$query = "delete from users where use_id = ?";				
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $this->id);				
			$deleted = $command->execute();
			mysqli_stmt_close($command);				
			parent::close_connection();				
			return $deleted;
		}		
		public function Update()
		{
			parent::open_connection();				
			$query = "UPDATE users SET Use_Email = ? , Use_Image = ?, Use_FirstName = ?, Use_LastName = ?, Use_Nickname = ?, Use_Password = sha1(?), Type_Id = ? where Use_Id = ?";				
			$command = parent::$connection->prepare($query);
			$command->bind_param('ssssssii', $this->email, $this->image, $this->first_name, $this->last_name, $this->nickname, $this->password, $this->type->get_id(), $this->id);				
			$updated = $command->execute();
			mysqli_stmt_close($command);				
			parent::close_connection();				
			return $updated;
		}	
		public function addscore($question, $answer, $time)
		{
			parent::open_connection();				
			$query = "INSERT INTO `score`(`Sco_Id`, `Use_Id`, `Que_Id`, `Ans_Id`, `Sco_Date`, `Sco_Time`) VALUES (null,?,?,?,NOW(), ?)";				
			$command = parent::$connection->prepare($query);
			$command->bind_param('iiii', $this->id, $question, $answer, $time);				
			$added = $command->execute();
			mysqli_stmt_close($command);				
			parent::close_connection();				
			return $added;
		}
			
	}
	
?>
