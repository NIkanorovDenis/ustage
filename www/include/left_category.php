<?
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri)[0];
$params = explode('/', $uri);

if ($params[1] == 'catalog' && !empty($params[2])) {

    $GLOBALS['i'] = 1;

    function parents($IBLOCK_SECTION_ID) {
            if (empty($IBLOCK_SECTION_ID)) return;

            $fn = '';

        $parent_res = CIBlockSection::GetList(
           Array('SORT' => 'ASC', 'ID' => 'ASC'), //сортировка
           Array('IBLOCK_ID' => 32, 'ACTIVE' => 'Y', 'ID' => $IBLOCK_SECTION_ID),
           false,
           array('IBLOCK_ID', 'ID', 'NAME', 'SECTION_PAGE_URL', 'IBLOCK_SECTION_ID') 
        );
        $parent_row = $parent_res->GetNext(); 

        $PARENT_ID = $parent_row['ID'];
        $PARENT_IBLOCK_SECTION_ID = $parent_row['IBLOCK_SECTION_ID'];
        $PARENT_NAME = $parent_row['NAME'];
        $PARENT_SECTION_PAGE_URL = $parent_row['SECTION_PAGE_URL'];

        if (!empty($PARENT_IBLOCK_SECTION_ID) && $PARENT_ID <> $PARENT_IBLOCK_SECTION_ID) {
             $fn .= parents($PARENT_IBLOCK_SECTION_ID);
        }

        if (!empty($PARENT_ID)) {
            $i = (int)$GLOBALS['i'];
            $fn .= '<div class="filter-category-wrap filter-category-wrap'.$i.'">
            <a class="filter-category" href="'.$PARENT_SECTION_PAGE_URL.'">'.$PARENT_NAME.'</a>
            </div>';
            $i++;
            $GLOBALS['i'] = $i;
        }

        return $fn;
    } 
    ?>

    <div class="rk-fullwidth prm_bxr_left">
        <div class="rk-fullwidth-canvas responsive">

            <div class="filter-category-wrapper bx_filter_parameters_box active">
                <span class="bx_filter_container_modef"></span>
                <div class="bx_filter_block" data-role="bx_filter_block" style="display: block;">
                    <div class="bx_filter_parameters_box_container">
                        <?
                        $GLOBALS['i'] = 1;
                        $CODE = $params[2];
                        $section_res = CIBlockSection::GetList(
                             Array('SORT' => 'ASC', 'NAME' => 'ASC'), //сортировка
                             Array('IBLOCK_ID' => 32, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'CODE' => $CODE),
                             false,
                             array('IBLOCK_ID', 'ID', 'NAME', 'SECTION_PAGE_URL', 'IBLOCK_SECTION_ID') 
                        );
                        while ($section_row = $section_res->GetNext()) { 

                            $ID = $section_row['ID'];
                            $IBLOCK_SECTION_ID = $section_row['IBLOCK_SECTION_ID'];
                            $NAME = $section_row['NAME'];
                            $SECTION_PAGE_URL = $section_row['SECTION_PAGE_URL'];

                            /* --- Родитель (если есть) --- */
                            $parents = parents($IBLOCK_SECTION_ID, $i);
                            if (!empty($parents)) {
                                echo $parents;
                            } 
                            /* --- // --- */

                            $i = $GLOBALS['i'];

                            //Дочерние
                            $section_res2 = CIBlockSection::GetList(
                             Array('SORT' => 'ASC', 'NAME' => 'ASC'), //сортировка
                             Array('IBLOCK_ID' => 32, 'ACTIVE' => 'Y', 'SECTION_ID' => $ID),
                             false,
                             array('IBLOCK_ID', 'ID', 'NAME', 'SECTION_PAGE_URL')
                            );
                            $section_count2 = $section_res2->SelectedRowsCount();
                            if ($section_count2 > 0) {
                                ?>
                                <div class="filter-category-wrap filter-category-wrap<?= $i ?>"> 
                                    <strong class="filter-category"><?= $NAME ?></strong>
                                </div>
                                <?
                                while ($section_row2 = $section_res2->GetNext()) {
                                    $ID2 = $section_row2['ID'];
                                $NAME2 = $section_row2['NAME'];
                                $SECTION_PAGE_URL2 = $section_row2['SECTION_PAGE_URL'];
                                ?>
                                <div class="filter-category-wrap filter-category-wrap<?= ($i + 1) ?>">
                                         <a class="filter-category" href="<?= $SECTION_PAGE_URL2 ?>"><?= $NAME2 ?></a>
                                    </div>
                                    <? 
                                } 
                             } 
                             else {
                                //Категории на том же уровне
                                $section_res3 = CIBlockSection::GetList(
                                  Array('SORT' => 'ASC', 'NAME' => 'ASC'), //сортировка
                                  Array('IBLOCK_ID' => 32, 'ACTIVE' => 'Y', 'SECTION_ID' => $IBLOCK_SECTION_ID),
                                  false,
                                  array('IBLOCK_ID', 'ID', 'NAME', 'SECTION_PAGE_URL')
                            );
                                while ($section_row3 = $section_res3->GetNext()) {
                                    $ID3 = $section_row3['ID'];
                                $NAME3 = $section_row3['NAME'];
                                $SECTION_PAGE_URL3 = $section_row3['SECTION_PAGE_URL'];
                                ?>

                                <? if ($ID3 == $ID) { ?>
                                <div class="filter-category-wrap filter-category-wrap<?= $i ?>"> 
                                    <strong class="filter-category"><?= $NAME ?></strong>
                                </div>
                                <? } else { ?>
                                <div class="filter-category-wrap filter-category-wrap<?= $i ?>">
                                        <a class="filter-category" href="<?= $SECTION_PAGE_URL3 ?>"><?= $NAME3 ?></a>
                                    </div>
                                    <? } ?>

                                    <?
                                }
                             } ?>

                        <? } ?>     
                    </div>
                    <div class="clb"></div>
                </div>
            </div>

        </div>
    </div>

<? } ?>