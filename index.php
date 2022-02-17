<?php
$errors = "";
$db = mysqli_connect("localhost", "root", "", "todolist");
if (isset($_POST['submit'])) {
	if (empty($_POST['Title']) or empty($_POST['Description'])) {
		$errors = "You must fill in the title and description";
	} else {
		$title = $_POST['Title'];
		$description = $_POST['Description'];
		$sql = "INSERT INTO todoitems (Title,Description) VALUES ('$title','$description')";
		mysqli_query($db, $sql);
		header('location: index.php');
	}
}
if (isset($_GET['del_task'])) {
	$id = $_GET['del_task'];
	mysqli_query($db, "DELETE FROM todoitems WHERE ItemNum=" . $id);
	header('location: index.php');
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>ToDo List</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">ToDo List</h2>
	</div>
	<form method="post" action="index.php" class="input_form">
		<input type="text" name="Title" class="task_input" placeholder="Title">
		<input type="text" name="Description" class="task_input" placeholder="Description">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Item</button>
	</form>

	<table>
		<thead>
			<tr>
				<th style="width: 120px" ;>Title</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$todoitems = mysqli_query($db, "SELECT * FROM todoitems");
			$i = 1;
			while ($row = mysqli_fetch_array($todoitems)) { ?>
				<tr>
					<td class="title"> <?php echo $row['Title']; ?> </td>
					<td class="description"> <?php echo $row['Description']; ?> </td>
					<td class="delete">
						<a href="index.php?del_task=<?php echo $row['ItemNum'] ?>">x</a>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
	<?php if (isset($errors)) { ?>
		<p><?php echo $errors; ?></p>
	<?php } ?>
</body>

</html>