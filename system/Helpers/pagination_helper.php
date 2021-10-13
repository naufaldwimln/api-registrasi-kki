<?php


/**
 * Helper unutk membuat paginasi dengan query manual
 * @return array ['data', 'link']
 */
function pagination($query = '', $limit = 10)
{
    $data['link'] = '';
    $data['data'] = '';

    if ($query != '') {
        $db     = db_connect();

        $total  = count($db->query($query)->getResult());

        // How many pages will there be
        $pages = ceil($total / $limit);

        // What page are we currently on?
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));

        // Calculate the offset for the query
        $offset = ($page - 1)  * $limit;


        $link_prev_page = ($page > 1) ? "?page=" . ($page - 1) : "?page=$page";
        $link_next_page = ($page < $pages) ? "?page=" . ($page + 1) : "?page=$page";

        $btn_first = '';
        $btn_prev = '';
        if ($page > 1) {
            $btn_first = '<li><a href="?page=1">First</a></li>';
            $btn_prev = '<li><a href="?page=' . ($page - 1) . '"><i class="bi bi-chevron-left"></i></a></li>';
        }

        $btn_last = '';
        $btn_next = '';
        if ($page < $pages) {
            $btn_last = '<li><a href="?page=' . $pages . '">Last</a></li>';
            $btn_next = '<li><a href="?page=' . ($page + 1) . '"><i class="bi bi-chevron-right"></i></a></li>';
        }


        // set html untuk pagination row
        $_html_row_pagin    = "";
        $_row_pagin         = ($page + 2) <= $pages ? ($page + 1) : $pages;


        for ($i = (($_row_pagin - 3 > 0) ? $_row_pagin - 3 : 0); $i < $_row_pagin; $i++) {

            $is_aktif = '';
            if ($page == ($i + 1)) {
                $is_aktif = ' class="active" ';
            }

            $_html_row_pagin .= '
            <li $is_aktif><a href="?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>
            ';
        }


        $html = '<div class="blog-pagination">
                    <ul class="justify-content-center">
                    ' . $btn_first . '
                    ' . $btn_prev . '
                    ' . $_html_row_pagin . '
                    ' . $btn_next . '
                    ' . $btn_last . '
                    </ul>
                </div>';
                
        // set Limit
        if ($total > 0) {
            $query .= "LIMIT $offset, $limit ";
        }

        // GET DATA
        $result = $db->query($query)->getResult();

        $data['data'] = $result;
        $data['link'] =  ($pages > 1) ? $html : '';
    }

    return $data;
}


function pagination2($query = '', $limit = 10)
{
    $data['link'] = '';
    $data['data'] = '';

    if ($query != '') {
        $db     = db_connect();

        $total  = count($db->query($query)->getResult());

        // How many pages will there be
        $pages = ceil($total / $limit);

        // What page are we currently on?
        $page = min($pages, filter_input(INPUT_GET, 'page2', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));

        // Calculate the offset for the query
        $offset = ($page - 1)  * $limit;


        $link_prev_page = ($page > 1) ? "?page2=" . ($page - 1) : "?page2=$page";
        $link_next_page = ($page < $pages) ? "?page2=" . ($page + 1) : "?page2=$page";


        // set html untuk pagination row
        $_html_row_pagin    = "";
        $_row_pagin         = ($page + 2) <= $pages ? ($page + 1) : $pages;


        for ($i = (($_row_pagin - 3 > 0) ? $_row_pagin - 3 : 0); $i < $_row_pagin; $i++) {

            $is_aktif = '';
            if ($page == ($i + 1)) {
                $is_aktif = 'active';
            }

            $_html_row_pagin .= '
            <li class="page-item ' . $is_aktif . ' "><a class="page-link" href="?page2=' . ($i + 1) . '">' . ($i + 1) . '</a></li>
            ';
        }


        $html = '
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?page2=1">First</a></li>
                <li class="page-item"><a class="page-link" href="' . $link_prev_page . '">Prev</a></li>
                ' . $_html_row_pagin . '
                <li class="page-item"><a class="page-link" href="' . $link_next_page . '">Next</a></li>
                <li class="page-item"><a class="page-link" href="?page2=' . $pages . '">Last</a></li>
            </ul>
        </nav>
        ';

        // set Limit
        if ($total > 0) {
            $query .= "LIMIT $offset, $limit ";
        }

        // GET DATA
        $result = $db->query($query)->getResult();

        $data['data'] = $result;
        $data['link'] =  ($pages > 1) ? $html : '';
    }

    return $data;
}



function pagination3($query = '', $limit = 10)
{
    $data['link'] = '';
    $data['data'] = '';

    if ($query != '') {
        $db     = db_connect();

        $total  = count($db->query($query)->getResult());

        // How many pages will there be
        $pages = ceil($total / $limit);

        // What page are we currently on?
        $page = min($pages, filter_input(INPUT_GET, 'page3', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));

        // Calculate the offset for the query
        $offset = ($page - 1)  * $limit;


        $link_prev_page = ($page > 1) ? "?page3=" . ($page - 1) : "?page3=$page";
        $link_next_page = ($page < $pages) ? "?page3=" . ($page + 1) : "?page3=$page";


        // set html untuk pagination row
        $_html_row_pagin    = "";
        $_row_pagin         = ($page + 2) <= $pages ? ($page + 1) : $pages;


        for ($i = (($_row_pagin - 3 > 0) ? $_row_pagin - 3 : 0); $i < $_row_pagin; $i++) {

            $is_aktif = '';
            if ($page == ($i + 1)) {
                $is_aktif = 'active';
            }

            $_html_row_pagin .= '
            <li class="page-item ' . $is_aktif . ' "><a class="page-link" href="?page3=' . ($i + 1) . '">' . ($i + 1) . '</a></li>
            ';
        }


        $html = '
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?page3=1">First</a></li>
                <li class="page-item"><a class="page-link" href="' . $link_prev_page . '">Prev</a></li>
                ' . $_html_row_pagin . '
                <li class="page-item"><a class="page-link" href="' . $link_next_page . '">Next</a></li>
                <li class="page-item"><a class="page-link" href="?page3=' . $pages . '">Last</a></li>
            </ul>
        </nav>
        ';

        // set Limit
        if ($total > 0) {
            $query .= "LIMIT $offset, $limit ";
        }

        // GET DATA
        $result = $db->query($query)->getResult();

        $data['data'] = $result;
        $data['link'] =  ($pages > 1) ? $html : '';
    }

    return $data;
}
