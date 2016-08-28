<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('conference.php');
	require_once('question.php');
	
	class Catalogs extends Connection
	{
		public static function get_conferences($id_event)
		{
			//open connection to MySql
			parent::open_connection();
			//initialize arrays
			$ids = array(); //array for ids
			$list = array(); //array for objects
			//query
			$query = "SELECT con_id
						FROM conference
						WHERE (
						Con_Date >= NOW( ) 
						OR Con_Time >= TIME( NOW( ) )
						)
						AND id_conference_event = ?";
			//prepare command
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $id_event);
			//execute command
			$command->execute();
			//link results
			$command->bind_result($id);
			//fill ids array
			while ($command->fetch()) array_push($ids, $id);
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i < count($ids); $i++) array_push($list, new Conference($ids[$i]));
			//return array
			return $list;
		}
		
		public static function get_questions($idconferences, $mode)
		{
			// mode 1 is for the question with the status = W *wait*
			// mode 2 is for the question with the status = A *acepted*
			// mode 3 is for the question with the status = D *declined*
			
			//open connection to MySql
			parent::open_connection();
			//initialize arrays
			$ids = array(); //array for ids
			$list = array(); //array for objects
			//query
			if($mode == 1)
			$query = "SELECT Que_Id FROM `questions` WHERE Que_Status = 'w' and con_id = ? order by Que_date desc";
			if($mode == 2)
			$query = "SELECT Que_Id FROM `questions` WHERE Que_Status = 'a' and con_id = ? order by Que_date desc";
			if($mode == 3)
			$query = "SELECT Que_Id FROM `questions` WHERE Que_Status = 'd' and con_id = ? order by Que_date desc";
			if($mode == 4)
			$query = "SELECT Que_Id FROM `questions` WHERE Que_Status = 't' and con_id = ? order by Que_date asc";
			if($mode == 5)
			$query = "SELECT Que_Id FROM `questions` WHERE Que_Status = 'p' and con_id = ? order by Que_date desc";
		
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $idconferences);
			//prepare command
			
			//execute command
			$command->execute();
			//link results
			$command->bind_result($id);
			//fill ids array
			while ($command->fetch()) array_push($ids, $id);
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i < count($ids); $i++) array_push($list, new Question($ids[$i]));
			//return array
			return $list;
		}
		
		public static function get_scores_by_conference($idConference)
		{
			$ids = array();
			$list = array();	
			parent::open_connection();
			//query
			$query = "SELECT DISTINCT s.Use_Id, tt.Aciertos, tt.time_milis
				FROM score s
				JOIN questions q ON s.Que_Id = q.Que_Id
				LEFT JOIN (
				
				SELECT s.Use_Id, COUNT( * ) AS Aciertos, SUM( s.Sco_Time ) AS time_milis
				FROM score s
				JOIN questions q ON q.Que_Id = s.Que_Id
				WHERE s.Ans_Id = q.Que_CorrectAns
				AND q.Con_Id =?
				GROUP BY s.Use_Id
				) AS tt ON s.Use_Id = tt.Use_Id
				WHERE q.Con_Id =?
				ORDER BY tt.Aciertos DESC , tt.time_milis ASC";
			//prepare command
			$command = parent::$connection ->prepare ($query);
			//link parameters
			$command -> bind_param('ii', $idConference, $idConference);
			//execute command
			$command -> execute();
			//link results
			$command ->bind_result($iduser, $aciertos, $time);
			//fill ids array
			while ($command -> fetch()){
				$score = new ScoreToConference();
				$score->set_right_answers($aciertos);
				array_push($ids, $iduser);
				array_push($list, $score);
			} 
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i <count ($ids); $i++)
			{
				$user = new User($ids[$i]);
				$list[$i]->set_user($user);
			}
			//return array
			return $list;
		}
		
		public static function get_time_scores($idConference, $idUser)
		{
			$count = 0;
			$sum = 0;
			$ids = array();
			parent::open_connection();
			//query
			$query = "SELECT s.Sco_Time
				FROM score s
				JOIN questions q ON q.Que_Id = s.Que_Id
				WHERE q.Con_Id =?
				AND s.Use_Id =?
				ORDER BY s.Sco_Time ASC";
			//prepare command
			$command = parent::$connection ->prepare ($query);
			//link parameters
			$command -> bind_param('ii', $idConference, $idUser);
			//execute command
			$command -> execute();
			//link results
			$command ->bind_result($time);
			//fill ids array
			while ($command -> fetch()){
				//array_push($ids, $time);
				if($count == 0) $ids[0] = $time;
				$sum = $sum + $time;
				$ids[1] = $time;
				$count = $count + 1;
			} 
			
			$ids[2] = round($sum / $count, 1);
			
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			//return array
			return $ids;
		}
		
		public static function get_count_persons($idquestion, $mode)
		{
			//mode 1 = correct
			//mode 2 = incorrect
			$query = "";
			parent::open_connection();$esaM =0;
			//query
			if($mode == 1){
			$query = "SELECT count(*) FROM questions q join score s on q.Que_id = s.Que_id WHERE q.Que_CorrectAns = s.Ans_id and q.Que_id = ?";
			}
			else if($mode == 2){
			$query = "SELECT count(*) FROM questions q join score s on q.Que_id = s.Que_id WHERE q.Que_CorrectAns <> s.Ans_id and q.Que_id = ?";
			}
			//prepare command
			$command = parent::$connection ->prepare ($query);
			//link parameters
			$command -> bind_param('i', $idquestion);
			//execute command
			$command -> execute();
			//link results
			$command ->bind_result($count);
			
			while ($command->fetch()) $esaM = $count;
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			//return array
			return $esaM;
		}
		
		
		/*Add by Dalia Pinto 01/04*/
		public static function get_scores_by_question($idQuestion)
		{
			$ids = array();
			$listAnswers = array();
			$list = array();	
			parent::open_connection();
			//query
			$query = "SELECT DISTINCT s.Use_Id, s.Sco_Date, s.Ans_Id 
					 FROM score s join users tt ON s.Use_Id = tt.Use_Id where s.Que_Id = ? 
					 ORDER BY s.Ans_ID ASC, s.Sco_Date ASC";
			//prepare command
			$command = parent::$connection ->prepare ($query);
			//link parameters
			$command -> bind_param('i', $idQuestion);
			//execute command
			$command -> execute();
			//link results
			$command ->bind_result($iduser, $time, $idanswer);
			//fill ids array
			while ($command -> fetch()){
				$score = new ScoreToConference();
				$score->set_time($time);
				array_push($ids, $iduser);
				array_push($listAnswers, $idanswer);
				array_push($list, $score);
			}
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i <count ($ids); $i++)
			{
				$user = new User($ids[$i]);
				$list[$i]->set_user($user);
				$answer = new Answer($listAnswers[$i]);
				$list[$i]->set_answer($answer);
			}
			//return array
			return $list;
		}
        
        public function getEvents($user)
		{
			//open connection to MySql
			parent::open_connection();
			//initialize arrays
			$ids = array(); //array for ids
			$list = array(); //array for objects
			//query
			$query = "select events.id_event from users, events where users.Type_Id = 1 and users.Use_Id = ? and events.id_admin = ?";
			//prepare command
			$command = parent::$connection->prepare($query);
			$command->bind_param('ii', $user, $user);
			//execute command
			$command->execute();
			//link results
			$command->bind_result($id);
			//fill ids array
			while ($command->fetch()) array_push($ids, $id);
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i < count($ids); $i++) array_push($list, new Event($ids[$i]));
			//return array
			return $list;
		}
		
        
        public function getAllEvents()
        {
            //open connection to MySql
			parent::open_connection();
			//initialize arrays
			$ids = array(); //array for ids
			$list = array(); //array for objects
			//query
			$query = "select events.id_event from events where events.name_of_event != 'onhold'";
			//prepare command
			$command = parent::$connection->prepare($query);
			//execute command
			$command->execute();
			//link results
			$command->bind_result($id);
			//fill ids array
			while ($command->fetch()) array_push($ids, $id);
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i < count($ids); $i++) array_push($list, new Event($ids[$i]));
			//return array
			return $list;
        }
        
        public function conferenceAndSpeaker($speaker, $conference)
        {
            parent::open_connection();			
			$query = "INSERT INTO `users_conference`(`Is_Speaker`, `Use_Id`, `Con_Id`) VALUES (1,?,?)";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('ii', $speaker, $conference);			
			$added = $command->execute();
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $added;
        }
		
		/*public static function get_user_by_facebook_id($facebook_id)
		{
			//receive arguments into an array
				//$args = func_get_args();
				//id
				//$nickname = $args[0];
				//open connection to MySQL
				$user = new User();
				parent::open_connection();
				//query
				$query = "select Use_Id from users where Use_FacebookId= ?";
				//prepare command
				$command = parent::$connection ->prepare($query);
				//link parameters
				$command ->bind_param('i', $facebook_id); 
				//execute command				
				$command -> execute();
				//link results to class attributes
				$command -> bind_result($croissant_id); 
				//fetch data 					
				$found = $command -> fetch();
				//close command 
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if($found)
					$user = new User($croissant_id);
				
				return $user;
		}*/
		
	}	
?>
