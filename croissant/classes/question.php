<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('conference.php');
	require_once('user.php');

	class Question extends Connection
	{
		//attributes
		private $id;
		private $question;
		private $dateOfQuestion;
		private $user;
		private $conference;
		private $status;
        private $correctAns;
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_question() { return $this->question; }
		public function set_question($value) { $this->question = $value; }
		public function get_dateOfQuestion() { return $this->dateOfQuestion; }
		public function set_dateOfQuestion($value) { $this->dateOfQuestion = $value; }
		public function get_user() {return $this->user; }
		public function set_user($value) { $this->user = $value; }
		public function get_conference() {return $this->conference; }
		public function set_conference($value) { $this->conference = $value; }
		public function get_status() {return $this->status; }
		public function set_status($value) { $this->status = $value; }
        public function get_correctAns() {return $this->correctAns; }
		public function set_correctAns($value) { $this->correctAns = $value; }
		//constructor
		function __construct()
		{
			//if no arguments received, create empty object
			if(func_num_args() == 0)
			{
				$this->id = 0;
				$this->question = '';
				$this->dateOfQuestion = date("Y-m-d H:i:s");
				$this->user = new User();
				$this->conference = new Conference();
				$this->status = '';
                $this->correctAns = 0;
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
				$query = "SELECT Que_Id, Que_correctAns ,Que_Question, Que_Date, Use_Id, Que_Status, Con_Id FROM `questions` WHERE Que_Id = ?";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('s', $id);
				//execute command
				$command->execute();
				//link results to class attributes
				$command->bind_result($id,$correctAns ,$question, $dateOfQuestion, $user, $sta, $conf);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if($found)
				{
					$this->id = $id;
                    $this->correctAns = $correctAns;
					$this->question = $question;
					$this->dateOfQuestion = $dateOfQuestion;
					$this->user = new User($user);
					$this->conference = new Conference($conf);
					$this->status = $sta;
				}
				else
				throw(new RecordNotFoundException());
			}
		}

		public function AddQuestionTrivia()
		{
			parent::open_connection();
			$query = "INSERT INTO `questions` (`Que_Question`,`Que_Date`, `Con_Id`, `Que_Status`,`use_id`) VALUES (?, ?, ?, ?, ?)";
			$command = parent::$connection->prepare($query);
			$userid = $this->user->get_id();
			$command->bind_param('ssisi', $this->question, $this->dateOfQuestion, $this->conference->get_id(), $this->status,$userid);
			$added = $command->execute();
			$id = $command->insert_id;
			$this->id = $id;
			mysqli_stmt_close($command);
			parent::close_connection();
			return $added;
		}
		public function UpdateTrivia()
		{
			parent::open_connection();
			$query = "UPDATE `questions` SET `Que_CorrectAns`= ? where `Que_Id`= ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('ii', $this->correctAns, $this->id);
			$updated = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $updated;
		}
		public function Add()
		{
			parent::open_connection();
			$query = "INSERT INTO `questions` (`Que_Id`, `Que_Question`,`Que_Date`, `Que_CorrectAns`,`Use_Id`, `Con_Id`, `Que_Status`) VALUES (NULL, ?, ?, DEFAULT, ?, ?, ?)";
			$command = parent::$connection->prepare($query);
			$userid = $this->user->get_id();
			$command->bind_param('ssiis', $this->question, $this->dateOfQuestion, $userid, $this->conference->get_id(), $this->status);
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
			$query = "UPDATE `questions` SET `Que_Question`= ?,`Que_Date`= ?, `Que_Status`= ? where `Que_Id`= ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssi', $this->question, $this->dateOfQuestion, $this->status, $this->id);
			$updated = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $updated;
		}
		//me traigo el id de la question
		//return con un array de tipo answers
		public function getAnswers()
		{
			//open connection to MySQL
			parent::open_connection();
			$ids = array();//array for ids
			$list = array();//array for objects
			//query
			$query = "select ans_id from answers where que_id = ?";
			//prepare command
			$command = parent::$connection ->prepare ($query);
			//link parameters
			$command -> bind_param('i', $this -> id);
			//execute command
			$command -> execute();
			//link results
			$command ->bind_result($id);
			//fill ids array
			while ($command -> fetch()) array_push($ids, $id);
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i <count ($ids); $i++) array_push($list, new Answer($ids[$i]));
			//return array
			return $list;
		}
		
		public function updateQuestion()
		{
			parent::open_connection();
			$query = "UPDATE `questions` SET `Que_Question`= ?,`Que_Date`= ?, `Que_CorrectAns`= ?  where `Que_Id`= ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssi', $this->question, $this->dateOfQuestion, $this->correctAns, $this->id);
			$updated = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $updated;
		}
		
		//Delete answers
		public function deleteAnswers()
		{
			parent::open_connection();			
			$query = "DELETE FROM `answers` WHERE `Que_Id`=?";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $this->id);			
			$deleted = $command->execute();
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $deleted;
		}	
	}
?>
