<div class="" style="min-height:100%; padding-top:61px; padding-bottom: 45px;">
    <!-- сортировка -->
    <div class="mt-2 sb-block">
        <div class="form-row">
            <label for="s-form-input-order" class="col col-form-label">Сортировка:</label>
            <div class="col form-group mb-0">
                <select class="form-control" id="task-sort-order" onchange="sort_tasks()">
                    <option value="0" <?= App::$showOrder==0 ? 'selected' : '' ?>>Номер задачи</option>
                    <option value="1" <?= App::$showOrder==1 ? 'selected' : '' ?>>Имя пользователя</option>
                    <option value="2" <?= App::$showOrder==2 ? 'selected' : '' ?>>Почта</option>
                    <option value="3" <?= App::$showOrder==3 ? 'selected' : '' ?>>Статус</option>
                </select>
            </div>
            <div class="col form-group mb-0">
                <select class="form-control" id="task-sort-tpp" onchange="sort_tasks()">
                    <option value="3" <?= App::$showPerPage==3 ? 'selected' : '' ?>>3</option>
                    <option value="5" <?= App::$showPerPage==5 ? 'selected' : '' ?>>5</option>
                    <option value="12" <?= App::$showPerPage==12 ? 'selected' : '' ?>>12</option>
                    <option value="34" <?= App::$showPerPage==34 ? 'selected' : '' ?>>34</option>
                </select>
            </div>
            <div class="col form-group mb-0">
                <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" id="task-sort-bw" <?= App::$showBackwards==1 ? 'checked' : '' ?> onchange="sort_tasks()">
                    <label class="form-check-label" for="s-form-input-bw">
                        В обратном порядке
                    </label>
                </div>
            </div>
        </div>
    </div>


    <!-- таски -->
    <?php

    if(isset($data))

      for($i=0; $i < count($data); $i+=1) {
          include 'views/task.php'; }

    ?>


    <!-- пагинация -->
    <div class="sb-block justify-content-center <?= App::$maxPages > 1 ? 'd-flex' : 'd-none' ?>">
        <div class="btn-toolbar" role="toolbar" aria-label="page button groups">

            <?php
                echo '<div class="btn-group" role="group" aria-label="page group">';

                if( App::$maxPages > 1) {
                    $left_page = 1;
                    $right_page = App::$maxPages;

                    if(App::$showPage > 3) $left_page = App::$showPage-2;
                    if(App::$showPage < App::$maxPages-2) $right_page = App::$showPage+2;

                    // страницы с левой до текущей
                    for($i=$left_page; $i < App::$showPage; $i+=1)
                        echo '<a href="main?page='.$i.'" class="btn btn-secondary">'.$i.'</a>';

                    // текущая страница
                    echo '<a href="main?page='.App::$showPage.'" class="btn btn-secondary"><strong>'.App::$showPage.'</strong></a>';

                    // страницы с текущей до правой
                    for($i=App::$showPage+1; $i <= $right_page; $i+=1)
                        echo '<a href="main?page='.$i.'" class="btn btn-secondary">'.$i.'</a>';

                }

			    echo '</div>';
            ?>

        </div>
    </div>
</div>