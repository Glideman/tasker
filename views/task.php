<div class="sb-block">
	<div class="row m-0">
		<div class="p-0 <?= $data[$i]->imgpath != '' ? '' : 'd-none' ?>">
			<img src="img/<?= $data[$i]->imgpath ?>" class="mr-3 float-left" alt="Загрузка...">
		</div>
		<div class="col p-0">
			<div class="row m-0">
				<div class="col p-0"><strong># <?= $data[$i]->taskid ?></strong><br><small><?= $data[$i]->status ?></small></div>
				<div class="col p-0"><strong><?= $data[$i]->name ?></strong><br><small><?= $data[$i]->mail ?></small></div>
				<div class="w-100 border my-3"></div>
				<p class="m-0"><?= $data[$i]->text ?></p>
			</div>
		</div>
	</div>
	<?= !is_null(App::$user) && ($data[$i]->user == App::$user->uid || App::$user->permissions == '2') ?
		'<div class="pt-1" ><a href="edittask?taskid='.$data[$i]->taskid.'">Редактировать</a></div>' :
		''
	?>
</div>