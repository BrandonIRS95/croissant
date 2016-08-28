<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');	
	
	class Answer extends Connection
	{
		//attributes
		private $id;
		private $answer;
		private $dated;
		private $question;
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_answer() { return $this->answer; }
		public function set_answer($value) { $this->answer = $value; }
		public function get_date() { return $this->dated; }
		public function set_date($value) { $this->dated = $value; }
		public function get_question() {return $this->question; }
		public function set_question($value) { $this->question = $value; }
		//constructor
		function __construct()
		{
			//if no arguments received, create empty object
			if(func_num_args() == 0) 
			{
				$this->id = 0;
				$this->answer = '';
				$this->question = 0;
				$this->dated= date("Y-m-d H:i:s");
			}
			//if one argument received create object with data
			if(func_num_args() == 1)
			{
				//receive arguments into an array
				$args = func_get_args();
				//id
				$id = $args[0];
				//open connection to MySql
				parent::open_connection();
				//query
				$query = "SELECT Ans_Id,Ans_Answer, Ans_Date, Que_Id FROM answers WHERE Ans_Id = ?";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('i', $id);
				//execute command
				$command->execute();
				//link results to class attributes
				$command->bind_result($this->id, $this->answer, $this->dated, $question);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if($found)					
					$this->question = new Question($question);
				else
					throw(new RecordNotFoundException());
			}
		}
		public function Add()
		{
			parent::open_connection();			
			$query = "INSERT INTO answers (Ans_Answer, Ans_Date,Que_Id) VALUES (?, ?, ?)";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('ssi', $this->answer, $this->dated, $this->question->get_id());			
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
			$query = "delete from `questions` where `Que_Id`  = ?";			
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
			$query = "update answers set `Ans_Answer` = ? where `Ans_Id` = ?";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('si', $this->answer, $this->id);			
			$updated = $command->execute();
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $updated;
		}				
	}
?>