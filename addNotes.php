<?php require_once ('header.php'); ?>

<form class= "newnote" id = "newnote" method = "post">
			<label for="title_note">Название заметки</label>
			<input type="text" name="title_note" id="title_note"/><br/>

			<label for="note">Заметка</label>
			<input type="textarea" name="note" id="note"/><br/>

			<input type="hidden" name="created" id="created" value="<?php echo date("Y-m-d"); ?>"/>

			<input type="button" value="Отправить" onclick= "validateForm();"/>
		</form>
		<?php
				$title = $_POST['title_note'];
				$created = $_POST['created'];
				$article = $_POST['note'];

				if ($title) {
                    $query = "INSERT INTO notes (id, created, title, article) VALUES (NULL, '$created', '$title', '$article')";
                    $insert_newnote = mysqli_query($link, $query);
                };
		?>
<script>
    function validateForm() {
        if ((document.getElementById('title_note').value)&&(document.getElementById('note').value)) {
            document.getElementById('newnote').submit();
        } else {
            alert("Введены не все данные");
        }
    };
</script>

<? require_once ('footer.php');?>