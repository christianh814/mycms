		    <table class="table table-bordered table-hover">
		      <thead>
		        <tr>
			  <th>Id</th>
			  <th>Username</th>
			  <th>Firstname</th>
			  <th>Lastname</th>
			  <th>Email</th>
			  <th>Role</th>
			  <th><center>Actions</center></th>
			</tr>
		      </thead>
		      <tbody>
			<?php
				$query = "SELECT * FROM users";
				$select_users = mysqli_query($connect, $query);
					while ($users = mysqli_fetch_assoc($select_users)) {
						$user_id = $users['user_id'];
						$user_name = $users['user_name'];
						$user_password = $users['user_password'];
						$user_firstname = $users['user_firstname'];
						$user_lastname = $users['user_lastname'];
						$user_email = $users['user_email'];
						$user_image = $users['user_image'];
						$user_role = $users['usre_role'];
						$rand_salt = $users['rand_salt'];
						// Put information in the table
						echo "<tr>";
						echo "<td>{$user_id}</td>";
						echo "<td>{$user_name}</td>";
						echo "<td>{$user_firstname}</td>";
						echo "<td>{$user_lastname}</td>";
						echo "<td>{$user_email}</td>";
						echo "<td>{$user_role}</td>";
						echo "<td>";
						echo "<center>";
						echo "<a href='users.php?source=edit_user&e_id={$user_id}' class='btn btn-warning' role='button'>Edit</a>";
						echo "&nbsp;&nbsp";
						echo "<a href='users.php?delete={$user_id}' class='btn btn-danger' role='button'>Delete</a>";
						echo "&nbsp;&nbsp";
						echo "<a href='users.php?makeadm={$user_id}' class='btn btn-success' role='button'>Promote To Admin</a>";
						echo "&nbsp;&nbsp";
						echo "<a href='users.php?makeusr={$user_id}' class='btn btn-info' role='button'>Convert To User</a>";
						echo "</center>";
						echo "</td>";
						echo "</tr>";
					}
	
			?>
		      </tbody>
		    </table>
			<?php
				// If we get a "delete" GET 
				if (isset($_GET['delete'])) {
					$the_user_id = $_GET['delete'];

					$query = "DELETE FROM users WHERE user_id = {$the_user_id} ";

					$delete_query = mysqli_query($connect, $query);

					confirmQuery($delete_query);
					header("Location: users.php");


				}
				// If we get an "makeadm" GET 
				if (isset($_GET['makeadm'])) {
					$the_user_id = $_GET['makeadm'];

					$query = "UPDATE users SET usre_role = 'admin' WHERE user_id = {$the_user_id} ";

					$mkadm = mysqli_query($connect, $query);

					confirmQuery($mkadm);
					header("Location: users.php");


				}
				// If we get an "makeusr" GET 
				if (isset($_GET['makeusr'])) {
					$the_user_id = $_GET['makeusr'];

					$query = "UPDATE users SET usre_role = 'subscriber' WHERE user_id = {$the_user_id} ";

					$mkusr = mysqli_query($connect, $query);

					confirmQuery($mkusr);
					header("Location: users.php");


				}
			?>
