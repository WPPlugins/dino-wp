<?php
/*
  Plugin Name: DINO WP
  Plugin URI: http://www.dino.com.br
  Description: Ferramenta para visualização de notícias distribuídas pelo DINO - Visibilidade Online.
  Version: 2.0.6
  Author: DINO
  Author URI: http://www.dino.com.br
  License: GPL2
 */

function _isCurl() {
    return function_exists('curl_version');
}

function dino_file_get_contents($site_url) {
    if (_isCurl()) {
        try {
            $ch = curl_init();
            $timeout = 10;
            curl_setopt($ch, CURLOPT_URL, $site_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($ch, CURLOPT_USERAGENT, 'DinoNews');
            $file_contents = curl_exec($ch);

            if ($file_contents === false) {
                echo "cURL Error: " . curl_error($ch);
            }

            curl_close($ch);
            return $file_contents;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        try {
            return file_get_contents($site_url);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    return null;
}

function fixAnchorQuotes($html) {
    $pattern = '/\'(?=[^<]*>)/';
    $replacement = '"';
    return preg_replace($pattern, $replacement, $html);
}

register_activation_hook(__FILE__, 'dino_plugin_install');

register_deactivation_hook(__FILE__, 'dino_plugin_remove');

add_filter('the_posts', 'dino_plugin_page_filter');

add_filter('parse_query', 'dino_plugin_query_parser');

if (is_admin()) {
    $wctest = new wctest();
}

//Functions

function dino_plugin_install() {
    global $wpdb;

    $the_page_title = "newsdino";
    $the_page_name = 'DINO';

    $the_pageList_title = "Noticias Corporativas";
    $the_pageList_name = "DINOLIST";

    $cssLivre = "";
    $cssTitulo = "display:none;";
    $cssResumo = "color:#808080; margin-top:5px; display:inline;";
    $cssLocal = "color:#08c; font-weight:bold;";
    $cssData = "font-weight:bold;";
	$TituloDaLista = "";
    $cssCorpo = "";
    $cssLink = "";
    $cssArquivos = "float:right; margin:3%; width:40%;";

    $mostrarLink = "no";

    $widgetH = 850;
    $widgetW = 340;

    $listH = 900;
    $listW = 670;

    $optionsCss = array("Livre" => $cssLivre, "Titulo" => $cssTitulo, "Resumo" => $cssResumo, "Local" => $cssLocal, "Data" => $cssData, "Corpo" => $cssCorpo, "Link" => $cssLink, "MostrarLink" => $mostrarLink, "Arquivos" => $cssArquivos, "TituloDaLista" => $TituloDaLista);
    $options = array("Parceiro" => "", "Html" => "");
    $optionsWidget = array("Height" => $widgetH, "Width" => $widgetW);
    $optionsList = array("Height" => $listH, "Width" => $listW);
    $optionsAparencia = array("CorTituloListagem" => "#ffffff");

    delete_option("dino_plugin_page_title");
    add_option("dino_plugin_page_title", $the_page_title, '', 'yes');

    delete_option("dino_plugin_page_name");
    add_option("dino_plugin_page_name", $the_page_name, '', 'yes');

    delete_option("dino_plugin_page_id");
    add_option("dino_plugin_page_id", '0', '', 'yes');

    delete_option("dino_plugin_option");
    add_option("dino_plugin_option", $options, '', 'yes');

    delete_option("dino_plugin_option_css");
    add_option("dino_plugin_option_css", $optionsCss, '', 'yes');

    delete_option("dino_plugin_widget");
    add_option("dino_plugin_widget", $optionsWidget, '', 'yes');

    //**************************************************************Lista

    delete_option("dino_plugin_pageList_title");
    add_option("dino_plugin_pageList_title", $the_pageList_title, '', 'yes');

    delete_option("dino_plugin_pageList_name");
    add_option("dino_plugin_pageList_name", $the_pageList_name, '', 'yes');

    delete_option("dino_plugin_pageList_id");
    add_option("dino_plugin_pageList_id", '0', '', 'yes');

    delete_option("dino_plugin_list");
    add_option("dino_plugin_list", $optionsList, '', 'yes');

    //*****************************************************

    $the_page = get_page_by_title($the_page_title);

    if (!$the_page) {

        $_p = array();
        $_p['post_title'] = $the_page_title;
        $_p['post_content'] = "DINO - Divulgador e Visibilidade Online. NÃO DELETE.";
        $_p['post_status'] = 'private'; //'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'
        $_p['post_name'] = $page_name;

        $the_page_id = wp_insert_post($_p);
    } else {

        $the_page_id = $the_page->ID;

        $the_page->post_status = 'private'; //'publish';
        $the_page->comment_status = 'closed';
        $the_page->ping_status = 'closed';
        $the_page->post_type = 'page';
        $the_page->post_content = "DINO - Divulgador e Visibilidade Online";
        $the_page->post_name = $page_name;
        $the_page_id = wp_update_post($the_page);
    }

    delete_option('dino_plugin_page_id');
    add_option('dino_plugin_page_id', $the_page_id);

    //**********************************************************************Lista

    $the_pageList = get_page_by_title($the_pageList_title);

    if (!$the_pageList) {
        $_pl = array();
        $_pl['post_title'] = $the_pageList_title;
        $_pl['post_content'] = "DINO - Divulgador e Visibilidade Online. Lista* - NÃO DELETE.";
        $_pl['post_status'] = 'private'; //'publish';
        $_pl['post_type'] = 'page';
        $_pl['comment_status'] = 'closed';
        $_pl['ping_status'] = 'closed';
        $_pl['post_category'] = array(1); // the default 'Uncatrgorised'
        $_pl['post_name'] = $pageList_name;

        $the_pageList_id = wp_insert_post($_pl);
    } else {
        $the_pageList_id = $the_page->ID;

        $the_pageList->post_status = 'private'; //'publish';
        $the_pageList->comment_status = 'closed';
        $the_pageList->ping_status = 'closed';
        $the_pageList->post_type = 'page';
        $the_pageList->post_content = "DINO - Divulgador e Visibilidade Online. Lista* - NÃO DELETE.";
        $the_pageList->post_name = $pageList_name;
        $the_pageList_id = wp_update_post($the_pageList);
    }

    delete_option('dino_plugin_pageList_id');
    add_option('dino_plugin_pageList_id', $the_pageList_id);
}

function dino_plugin_remove() {
    global $wpdb;

    $the_page_title = get_option("dino_plugin_page_title");
    $the_page_name = get_option("dino_plugin_page_name");
    $the_page_id = get_option('dino_plugin_page_id');
    if ($the_page_id) {
        wp_delete_post($the_page_id); // this will trash, not delete
    }

    //*******************************************************************Lista

    $the_pageList_title = get_option("dino_plugin_pageList_title");
    $the_pageList_name = get_option("dino_plugin_pageList_name");
    $the_pageList_id = get_option('dino_plugin_pageList_id');
    if ($the_pageList_id) {
        wp_delete_post($the_pageList_id); // this will trash, not delete
    }

    delete_option("dino_plugin_page_title");
    delete_option("dino_plugin_page_name");
    delete_option("dino_plugin_page_id");

    delete_option("dino_plugin_pageList_title");
    delete_option("dino_plugin_pageList_name");
    delete_option("dino_plugin_pageList_id");

    delete_option("dino_plugin_option");
    delete_option("dino_plugin_option_css");
    delete_option("dino_plugin_widget");
    delete_option("dino_plugin_list");
}

function dino_plugin_page_filter($posts) {
    global $wp_query;
    global $_GET;
    global $_SERVER;

    $_GET_lower = array_change_key_case($_GET, CASE_LOWER);

    if (!is_null($wp_query)) {
        if ($wp_query->get('dino_plugin_page_is_called')) {
            $posts[0] = new stdClass();
            $releaseid = $_GET_lower["releaseid"];

            $dino_options = get_option('dino_plugin_option');
            $parceiro_id = $dino_options["Parceiro"];

            $montaNoticia = get_transient('dino_page_release_' . $releaseid);

            /***********CONSOME API V2/NEWS PRA MONTAR O SINGLE DE CADA NOTICIA***********/
            $url = "http://api.dino.com.br/v2/news/" . $releaseid . "/dino";
            $json = dino_file_get_contents($url);
            $result = json_decode($json);
            $montaNoticia = $result->Item;
            
            if ($montaNoticia == false) {
                $url = "http://api.dino.com.br/v2/news/" . $releaseid . "/dino";
                $json = dino_file_get_contents($url);
                $result = json_decode($json);
                $montaNoticia = $result->Item;

                set_transient('dino_page_release_' . $releaseid, $montaNoticia, 3600);
            }
            
            $date = new DateTime($montaNoticia->{'PublishedDate'});
            $css = get_option('dino_plugin_option_css');
            $opti = get_option('dino_plugin_option');
            $html = $opti["Html"];
            $cont = '<div>' . $html . '</div>';

            if ($montaNoticia->Title == null || $releaseid == null) {
                $posts[0]->post_title = "Notícia não localizada";

                $cont .= '<div class="entry-content"><p>Notícia não encontrada, verifique o endereço digitado.</p></div>';
                $posts[0]->post_content = $cont;
            } else {
                $cont .= '<div class="entry-content-dino">';
                $cont .= '<div class="dinotitulo"><h1 class="entry-title">' . $montaNoticia->Title . '</h1></div>';
                $cont .= '<div><div><h2 class="dinoresumo ">'. $montaNoticia->Summary .'</h2></div>';
                
                $cont .= '<div class="dinoarquivos">';

                if ($montaNoticia->Image->Url != null) {
                    $imagem = substr($montaNoticia->Image->Url, 0, strpos($montaNoticia->Image->Url, "?"));
                    $cont .= '<img width="100%" itemprop="photo" title="'.$montaNoticia->Image->Alt.'" alt="'.$montaNoticia->Image->Alt.'" src="' . $imagem . '?quality=80&width=100%&height=400"/><br/>';
                    if( !empty($montaNoticia->Image->Description) ){
                        if ( !empty($montaNoticia->Image->Source) ){
                            $fonteNoticia = '( '.$montaNoticia->Image->Source . ' )';
                        }
                        $cont .= '<div class="image-alt-dino">' .$montaNoticia->Image->Description. ' '.$fonteNoticia.'</div>';
                    }
                if( empty($montaNoticia->Image->Description) ){
                        $cont .= '<p style="color:transparent;padding:0;margin:0;float:left;width:100%;margin-bottom:-20px;">dino</p>';
                    }
                }

                $cont .= '</div>'; //fechando div arquivos

                if( $montaNoticia->VideoUrl->Url != null || $montaNoticia->Quote != null  ):
                    $cont .= '<div class="video-e-ccaption-dino">';
                        $cont .= '<div class="video-plugin-dino">';
                        if ($montaNoticia->VideoUrl->Url != null) {
                            $cont .= '<iframe src="' . $montaNoticia->VideoUrl->Url . '?rel=0" frameborder="0" allowfullscreen></iframe>';
                            $cont .= '<div class="descricao-video-plugin"><p>'.$montaNoticia->VideoUrl->Descricao.'</p></div>';
                        }
                        $cont .= '</div>';

                        $cont .= '<div class="caption-plugin-dino">';
                        if(!empty( $montaNoticia->Quote)) {
                            $cont .= '<i class="fa fa-quote-left" aria-hidden="true"></i><p>' . $montaNoticia->Quote . '</p></div>';
                        }
                    $cont .= '</div>';
                endif;

                if( !empty($montaNoticia->Place) ){
                    $semCidade = '<br/><div class="cidade-local-dino"><span class="dinolocal">'.$montaNoticia->Place. ', </span>';
                }

               $cont .= '</div><br/><div class="conteudo-dino-plugin">'.$semCidade.'<span class="dinodata">'.$date->format("d/m/Y") . ' - </span></div>';
                $cont .= fixAnchorQuotes($montaNoticia->Body) . '</div>';
                
                $titleUrl = urlencode($montaNoticia->Title);
                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&title=$titleUrl";
                $ReleaseIdFace = $montaNoticia->ReleaseId;

                 $tituloTwitter = $montaNoticia->Title;
                $urlTwitter = $montaNoticia->Url;
                $actual_link2 = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                $cont .= '<img src="//api.dino.com.br/v2/news/tr/' . $releaseid . '?partnerId=' . $parceiro_id . '" alt="" style="width:0px;height:0px;border:0;" />';
                $cont .= '</p>';
                if (isset($css["MostrarLink"])) {
                    if ($css["MostrarLink"] == "on") {
                        $cont .= '<div class="dinolink"><a href="' . $montaNoticia->Url . '">Leia mais</a></div>';
                    }
                }
                $cont .= '</div><style>.image-alt-dino{float: left;width: 100%;margin-bottom: 17px;font-size: 11px;color: #888;}.video-e-ccaption-dino{float: right;width: 45%;margin-left: 10px;}.descricao-video-plugin{float: left;margin-top: -10px;color: #888;}.descricao-video-plugin p {float: left !important;width: 100% !important;    font-size: 11px;color: #888 !important;font-weight: 500 !important;line-height: 15px;}#bwbodyimg{width:100%!important;}.caption-plugin-dino p {float: right;width: 87%;max-width: 100%;margin-bottom:0;font-weight:700;color:#000;}.caption-plugin-dino{float: right;width: 100%;font-weight: 700;font-size: 15px;padding-left: 5px;margin-bottom: 10px;}.fa-quote-left{float: left;margin-right: 9px;margin-top: 2px;font-size: 26px;color: #000;}.conteudo-dino-plugin{font-size: 15px;color: #444;text-align: left;}.dinotitulo h1{font-size:40px;color: '.$css['CorTituloInterno'].';margin-top:0;margin-bottom:10px;line-height:43px;}.dinolocal{font-size:15px;color:'.$css['CorLocalInterno'].';float:left;}.dinodata{float: left;margin-left: 10px;margin-right: 10px;font-size:15px;color:'.$css['CorLocalInterno'].'}h2.dinoresumo{font-size:18px;color:'.$css['CorResumoInterno'].';font-weight:300;margin-top:10px;line-height: 24px;}.dinocorpo{font-size:' . $css["Corpo"] . 'px;color:'.$css['CorCorpoInterno'].';}.dinolink{' . $css["MostrarLink"] . '}.dinoarquivos iframe{margin-top:16px;}.dinoarquivos img{width:100%;float:left;margin-bottom:7px;}.dinoarquivos{' . $css["Arquivos"] . '}' . $css["Livre"] . '</style>';

                $analytics = '<script type="text/javascript" title="Analytics">';
                $analytics .= "var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-28239442-1']);";
                $analytics .= "_gaq.push(['_setCustomVar', 1, 'partner', '" . $opti["Parceiro"] . "', 3]);_gaq.push(['_setCustomVar', 2, 'release', '" . $releaseid . "', 3]);_gaq.push(['_trackPageview']);";
                $analytics .= "(function () {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>";

                $ti = get_bloginfo();
                $script = '<script type="text/javascript" title="Titulo">var titulo = "' . $montaNoticia->Title . " | " . $ti . '"; if (document.title.search("newsdino") !== -1){ document.title = titulo; } </script>';
                $posts[0]->post_content = $cont . $analytics . $script;
                $posts[0]->comment_status = "closed";
                $posts[0]->ping_status = "closed";
                $hook = add_action("wp_head", "page_meta");

                if (!function_exists("page_meta")) {

                    function page_meta() {
                        $releaseid2 = $_GET["releaseid"];

                        $montaNoticia = get_transient('dino_page_release_' . $releaseid2);
                        //$release2 = false; //get_transient('dino_page_release_'.$releaseid2);

                        /***********CONSOME API V2/NEWS PRA MONTAR O SINGLE DE CADA NOTICIA***********/
                        $url2 = "http://api.dino.com.br/v2/news/" . $releaseid2 . "/dino";
                        $json2 = dino_file_get_contents($url2);
                        $result2 = json_decode($json2);
                        $montaNoticia = $result2->Item;
                        /**********************/

                        if ($montaNoticia === true) {
                            $url2 = "http://api.dino.com.br/v2/news/" . $releaseid2 . "/dino";
                            $json2 = dino_file_get_contents($url2);
                            $result2 = json_decode($json2);
                            $montaNoticia = $result2->Item;

                            set_transient('dino_page_release_' . $releaseid2, $montaNoticia, 3600);
                        }

                        $summary = encurtador($montaNoticia->Summary, 160);
                        $title = encurtador($montaNoticia->Title, 170);
                        $titleUrl = urlencode($montaNoticia->Title);
                        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&title=$titleUrl";

                        $metaContent = '<meta name="description" content="' . "$summary" . '" />';
                        $metaContent .= '<meta property="og:title" content="' . "$title" . '" />';
                        $metaContent .= '<meta  property="og:description" content="' . "$summary" . '" />';

                        if ($montaNoticia->Image->Url != null) {
                            $image = substr($montaNoticia->Image->Url, 0, strpos($montaNoticia->Image->Url, "?")) . "?quality=60&width=300&height=300";
                            $metaContent .= '<meta  property="og:image" content="' . "$image" . '" />';
                        }

                        return print($metaContent);
                    }

                }

                do_action("$hook");
            }
        }

        if ($wp_query->get('dino_plugin_list_is_called')) {

            $posts[0] = new stdClass();

            $list_options = get_option('dino_plugin_list');
            $dino_options = get_option('dino_plugin_option');

            $list_h = $list_options["Height"];
            $list_w = $list_options["Width"];
            $parceiro_id = $dino_options["Parceiro"];

            if ($list_h == null || $list_h == 0) {
                $list_h = 900;
            }

            if ($list_w == null || $list_w == 0) {
                $list_w = 670;
            }

            $pageIndex = $_GET_lower["pageindex"];
            $pageSize = $_GET_lower["pagesize"];
            $find = $_GET_lower["find"];
            
            $data = array("pageIndex" => isset($pageIndex) ? $pageIndex : 1, "pageSize" => isset($pageSize) ? $pageSize : 10);
            if(isset($find) && !empty($find))
            {
                $data["find"] = $find;
            }
            $curl = curl_init();
            
            $url = "http://api.dino.com.br/v2/news";
            if(!isset($parceiro_id) || empty($parceiro_id))
                $url = "http://api.dino.com.br/v2/partners/$parceiro_id/news";
            
            $url = sprintf("%s?%s", $url, http_build_query($data));
            $json = dino_file_get_contents($url);
            $result = json_decode($json);

            $posts[0]->post_title = "NOTÍCIAS CORPORATIVAS";
            $html = "<style>
                    .media:first-child {
                            margin-top: 0;
                    }
                    .media, .media-body {
                            overflow: hidden;
                            zoom: 1;
                    }
                    .media-body {
                        padding-left:10px;
                    }
                    .media-body, .media-left, .media-right {
                            display: table-cell;
                            vertical-align: top;
                            width:45%;
                    }
                    .dino-list .media-left img {
                        // position: relative;
                        // top: 50%;
                        // -webkit-transform: translateY(-50%);
                        // -ms-transform: translateY(-50%);
                        // transform: translateY(-50%);
                    }
                    .media-left a{
                            display:block;
                            width: 70px;
                            text-decoration:none;
                            box-shadow:none;
                    }
                    .media-object {
                            display: block;
                            vertical-align: middle;
                            border:0;
                            width:100%;
                    }
                    .media-body, .media-left, .media-right {
                            display: table-cell;
                            vertical-align: top;
                    }
                    .media-body {
                            width: 10000px;
                    }
                    .media, .media-body {
                            overflow: hidden;
                            zoom: 1;
                    }
                    .media-heading {
                            margin-top: 0 !important;
                            margin-bottom: 5px !important;
                    }
                    .dino-pagination li.page-item.primeiro-lst {
                        width: 55px;
                        font-size: 12px;
                    }
                    .dino-pagination li.page-item.ultima-lst {
                        width: 55px;
                        font-size: 12px;
                    }
                    .dino-pagination{
                        list-style: none;
                        padding: 0;
                        width: 100%;
                        margin: 0 auto;
                        text-align: center;
                        float:left;
                        margin-bottom:30px;
                    }
                    .dino-pagination > li {
                        display: inline-block;
                        padding-top: 5px;
                        font-weight: 700;
                        padding-bottom: 5px;
                        font-size: 15px;
                        color: #7c7c7c;
                        width: 36px;
                        text-align: center;
                    }
                    li.page-item.dino-active {
                        background: #282828;
                        border-radius: 30px;
                    }
                    .dino-active a {
                        color: #fff !important;
                    }
                    .media.noticias-dino-lista:last-child {
                        padding: 0;
                    }
                    .page-item a{
                        color: #333;
                    }
                    @media (min-width: 768px)
                    {
                        .dino-news .form-inline .form-group {
                            display: inline-block;
                            margin-bottom: 0;
                            vertical-align: middle;
                        }
                        .dino-news .form-inline .form-control {
                            display: inline-block;
                            width: auto;
                            vertical-align: middle;
                        }
                        .dino-news .form-inline p {
                            display: inline-block;
                        }
                    }
                    .dino-news .form-group {
                        margin-bottom: 15px;
                    }
                    .dino-news label {
                        display: inline-block;
                        max-width: 100%;
                        margin-bottom: 5px;
                        font-weight: 700;
                    }
                    .dino-news .form-control {
                        display: block;
                        width: 100%;
                        line-height: 1.42857143;
                    }
                </style>";

            //<link rel='stylesheet' href='" . plugins_url('dino-wp/assets/css/bootstrap.min.css', dirname(__FILE__)) . "' type='text/css' media='all' />";

            if ($result->Success == 1) {

                if (isset($result->Items)) {
                    $url=strtok($_SERVER["REQUEST_URI"],'?');
                    
                    $html.= '<div class="dino-news"><div class="dino-list">';

                    //echo '<pre>' . print_r($result, true) . '</pre>'; exit;				
                    foreach ($result->Items as $item) {
                        //Jonathan -> de o name do textarea que recebe o estilo de dino_plugin_option_css[TituloDaLista] e chamei no style do h5 class media-heading
                        $opLista = get_option('dino_plugin_option_css');

                        $html .= "<div class='media noticias-dino-lista' height='70' style='margin-bottom:50px;width: 100%;float: left;overflow: hidden;'>";
                        if (isset($item->Image) && !empty($item->Image->Url)) {
                            $html .= "<div class='img-overflow-dino' style='border: 1px solid #ccc;border-radius: 3px;float: left;width: 50%;overflow: hidden;height: 225px;display: flex;align-items: center;'><div class='media-left' style='width: 100%;padding:0;'><a style='border:none;width:100%;height:auto;overflow: hidden;' href='?page_id=" . get_option('dino_plugin_page_id') . "&releaseid=" . $item->ReleaseId . "&title=". $item->Title ."' rel='nofollow'><img class='media-object' src='" . reset((explode('?', $item->Image->Url))) . "?quality=30&width=100%&height=400' alt='".$item->Image->Alt."' title='".$item->Image->Alt."'/></a></div></div>";
                        } else {
                            $html .= "<div class='img-overflow-dino' style='border: 1px solid #ccc;border-radius: 3px;float: left;width: 50%;overflow: hidden;height: 225px;display: flex;align-items: center;'><div class='media-left' style='width: 100%;padding:0;><a style='width:".$opLista['imagemListaNoticias']."px;height:".$opLista['imagemListaNoticias']."px;overflow: hidden;' href='?page_id=" . get_option('dino_plugin_page_id') . "&releaseid=" . $item->ReleaseId . "&title=". $item->Title ."' rel='nofollow'><img class='media-object' src='https://app.dino.com.br/content/images/sem-img-widget.jpg' alt='' /></a></div></div>";
                        }

                        $html .="<div class='media-body'><a style='border:none;' href='?page_id=" . get_option('dino_plugin_page_id') . "&releaseid=" . $item->ReleaseId . "&title=". $item->Title ."' rel='nofollow'><span style='font-size:".$opLista['TamanhoDataLista']."px;color:".$opLista['CorDataLista'].";'><small style='font-size: 11px;'>" . date('d/m/Y', strtotime($item->PublishedDate)) . "</small></span><h5 class='media-heading' 
                        style='font-size:17px;color:".$opLista['CorTituloLista'].";text-transform: none;line-height: 23px;letter-spacing: 0px;'>" . $item->Title . "</h5><p class='media-text' style='font-size:13px;line-height: 19px;font-weight: 200;'>" . encurtador($item->Summary, 120) . "</p></a></div></div>";
                    }
                    $html .= "</div></div>";

                    $html .= dino_render_pagination($result);
                }
            }


            $posts[0]->post_content = $html;
            $posts[0]->comment_status = "closed";
            $posts[0]->ping_status = "closed";

            return $posts;
        }

        return $posts;
    }
}

function dino_render_pagination($result) {
    //echo '<pre>' . print_r($result, true) . '</pre>'; exit;   

    $html = "";
    $pageSize = intval($result->PageSize);
    $total = intval($result->Total);
    $pages = ceil($total / $pageSize);
    $page = intval($result->PageIndex);
    $range = 9;
    $half = floor($range / 2);

    //var_dump($pageSize);exit;
    if ($pages > 1) {
        $min = 1;
        $max = $pages;

        if ($pages > $range) {
            $min = $page - $half;
            $max = $page + $half;

            if ($min <= 0) {
                $min = 1;
            }
            if ($max > $pages) {
                $max = $pages;
            }
        }

        $html .= "<ul class=\"dino-pagination\">";
        if ($pages > 1 && $page > 1) {
            $html .= dino_render_page_item("Anterior", $page - 1, $pageSize, "primeiro-lst");
        }
        if ($pages > $range && $min > 1) {
            $html .= dino_render_page_item("1", 1, $pageSize, null);

            if ($min > 2) {
                $html .= dino_render_page_item("...", null, $pageSize, "dino-active");
            }
        }
      
        for ($i = $min; $i <= $max; $i++) {
            if ($i == $page)
                $html .= dino_render_page_item($i, null, $pageSize, "dino-active");
            else
                $html .= dino_render_page_item($i, $i, $pageSize, null);
        }

        
        if ($pages > 1 && $page < $pages) {
            $html .= dino_render_page_item("Próximo", $page + 1, $pageSize, 'ultima-lst');
        }
        
        $html .= "</ul>";
    }
    return $html;
}

function dino_render_page_item($text, $index, $size, $cssClass) {
    $css = "page-item";
    if (isset($cssClass) && !empty($cssClass))
        $css .= " " . $cssClass;
    return "<li class=\"" . $css . "\"><a href=\"" . (isset($index) ? "?PageIndex=" . $index . "&PageSize=" . $size : "javascript:;") . "\"" . (isset($index) ? " data-index=\"" . $index . "\"" : "") . ">" . $text . "</a></li>";
}

function dino_plugin_query_parser($q) {
    $pp = get_page_by_title(get_option('dino_plugin_page_title'));
    $the_page_name = $pp->post_name;
    $the_page_id = get_option('dino_plugin_page_id');

    $ppl = get_page_by_title(get_option('dino_plugin_pageList_title'));
    $the_pageList_name = $ppl->post_name;
    $the_pageList_id = get_option('dino_plugin_pageList_id');

    $qv = $q->query_vars;

    if (!$q->did_permalink AND ( isset($q->query_vars['page_id']) ) AND ( intval($q->query_vars['page_id']) == $the_page_id )) {
        $q->set('dino_plugin_page_is_called', true);
        return $q;
    } elseif (isset($q->query_vars['pagename']) AND ( ($q->query_vars['pagename'] == $the_page_name) OR ( $_pos_found = strpos($q->query_vars['pagename'], $the_page_name . '/') === 0))) {
        $q->set('dino_plugin_page_is_called', true);
        return $q;
    } elseif (!$q->did_permalink AND ( isset($q->query_vars['page_id'])) AND ( intval($q->query_vars['page_id']) == $the_pageList_id)) {
        $q->set('dino_plugin_page_is_called', false);
        $q->set('dino_plugin_list_is_called', true);
        return $q;
    } elseif (isset($q->query_vars['pagename']) AND ( ($q->query_vars['pagename'] == $the_pageList_name) OR ( $_pos_found = strpos($q->query_vars['pagename'], $the_pageList_name . '/') === 0))) {
        $q->set('dino_plugin_list_is_called', true);
        return $q;
    } else {
        $q->set('dino_plugin_list_is_called', false);
        return $q;
    }
}

function dino_admin_menu() {
    add_options_page('DINO - WP Plugin Settings', 'DINO - WP', 'administrator', __FILE__, 'dino_setting_page', plugins_url('/images/icon.png', _FILE_));
    add_action('admin_init', 'register_dinosettings');
}

function register_dinosettings() {
    register_setting('dino_settings_group', 'dino_plugin_option');
    register_setting('dino_settings_group', 'dino_plugin_option_css');
    register_setting('dino_settings_group', 'dino_plugin_list');
}

function encurtador($texto, $tamanho) {
    $t = strip_tags($texto);
    if (strlen($texto) > $tamanho) {
        return substr($t, 0, $tamanho - 3) . '...';
    }
    return $t;
}

function dinopagelink() {
    global $wpdb;
    $pageid = get_option('dino_plugin_page_id');
    $actual_link = "http://$_SERVER[HTTP_HOST]?page_id=$pageid";
    return $actual_link;
}

function dinopagelistLink() {
    global $wpdb;
    $pageid = get_option('dino_plugin_pageList_id');
    $actual_link = "http://$_SERVER[HTTP_HOST]?page_id=$pageid";
    return $actual_link;
}

class wctest {

    public function __construct() {
        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_plugin_page'));

            add_action('admin_init', array($this, 'page_init'));

            function pw_load_scripts() {
                wp_enqueue_style('dinoadmin-css', plugins_url('dino-wp/assets/css/dinoAdmin.css', dirname(__FILE__)));
                wp_enqueue_style('dinoadmin-css-bots-min', plugins_url('dino-wp/assets/css/bootstrap.min.css', dirname(__FILE__)));
                //wp_enqueue_style('dinoadmin-css-bots', plugins_url('dino-wp/assets/css/bootstrap.css', dirname(__FILE__)));
            
               
                //wp_enqueue_script('bootstrap-js-n', plugins_url('dino-wp/assets/js/bootstrap.js', dirname(__FILE__)));
                wp_enqueue_script('jquery-1102-js', plugins_url('dino-wp/assets/js/jquery-1.10.2.min.js', dirname(__FILE__)));
                 wp_enqueue_script('bootstrap-js', plugins_url('dino-wp/assets/js/bootstrap.min.js', dirname(__FILE__)));
                wp_enqueue_script('dinoadmin-js', plugins_url('dino-wp/assets/js/dinoAdmin.js', dirname(__FILE__)));
            }

            if (isset($_GET['page']) && ($_GET['page'] == 'dino_setting_page')) {
                add_action('admin_enqueue_scripts', 'pw_load_scripts');
            }
        }
    }

    public function add_plugin_page() {
        add_options_page('DINO - WP Plugin Settings', 'DINO - WP', 'manage_options', 'dino_setting_page', array($this, 'create_admin_page'));
    }

    public function create_admin_page() {
        ?>
        <div class="wrap">
        <?php screen_icon(); ?>
            <h2>DINO - WP Configurações</h2>			
            <form method="post" action="options.php">
        <?php settings_fields('dino_option_group'); ?>
                <br/>

                <div id="dinoCaixa">
                    <ul class="nav nav-tabs" id="dino-tabs">
                        <li class="active"><a href="#dino-geral" data-toggle="tab">Geral</a></li>
                        <li><a href="#dino-aparencia" data-toggle="tab">Aparência</a></li>
                        <li><a href="#dino-lista" data-toggle="tab">Listagem</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="dino-geral"><?php do_settings_sections('dino-setting-admin'); ?></div>
                        <div class="tab-pane" id="dino-aparencia"><?php do_settings_sections('dino-setting-admin-css'); ?></div>
                        <div class="tab-pane" id="dino-lista"><?php do_settings_sections('dino-setting-admin-list'); ?></div>
                    </div>
                </div>

        <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function page_init() {
        register_setting('dino_option_group', 'dino_plugin_option');
        register_setting('dino_option_group', 'dino_plugin_option_css');
        register_setting('dino_option_group', 'dino_plugin_list');

        add_settings_section(
                'sessao_info', 'Geral', array($this, 'print_section_info'), 'dino-setting-admin'
        );

        add_settings_field(
                'dino_plugin_option', '', array($this, 'create_options_field'), 'dino-setting-admin', 'sessao_info'
        );

        add_settings_section(
                'sessao_aparencia', 'Aparência', array($this, 'print_section_aparencia'), 'dino-setting-admin-css'
        );

        add_settings_field(
                'dino_plugin_option_css', '<div id="classes">Classes<ul><li>.dinotitulo</li><li>.dinoresumo</li><li>.dinolocal</li><li>.dinodata</li><li>.dinocorpo</li><li>.dinolink</li><li>.dinoarquivos</li></ul></div>', array($this, 'create_css_field'), 'dino-setting-admin-css', 'sessao_aparencia'
        );

        add_settings_section(
                'sessao_lista', 'Listagem', array($this, 'print_section_lista'), 'dino-setting-admin-list'
        );

        add_settings_field(
                'dino_plugin_list', '', array($this, 'create_list_field'), 'dino-setting-admin-list', 'sessao_lista'
        );
    }

    public function print_section_aparencia() {
        print 'CSS:';
    }

    public function print_section_lista() {
        print 'Listagem:';
    }

    public function print_section_info() {
        print "Informações";
    }

    public function print_pagina_noticia() {
        print '<a href="' . dinopagelink() . '">' . dinopagelink() . '</a>';
    }

    public function create_css_field() {
        $op = get_option('dino_plugin_option_css');
        if (!isset($op['MostrarLink'])) {
            $op['MostrarLink'] = "off";
        }


        $cssLivre = "";
        $cssnew = "";
        $cssTitulo = "display:none;";
        $cssResumo = "color:#808080; margin-top:5px; display:inline;";
        $cssLocal = "color:#08c; font-weight:bold;";
        $cssData = "font-weight:bold;";
        $cssCorpo = "";
        $cssLink = "";
        $cssArquivos = "float:right; margin:3%; width:40%;";
        ?>

        <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#listagemDeNoticiaTable" aria-controls="home" role="tab" data-toggle="tab">Listagem de notícias</a></li>
            <li role="presentation"><a href="#noticiaInternaTable" aria-controls="profile" role="tab" data-toggle="tab">Notícias</a></li>
            <li role="presentation"><a href="#personalizeInternaTable" aria-controls="profile" role="tab" data-toggle="tab">Personalização Avançada</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="listagemDeNoticiaTable">

        <div>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Defina a cor do título">Cor do título</button><span class="restaurar" id="restartColorTituloLista">[restaurar]</span>
            <input id="corInput" type="color" name="dino_plugin_option_css[CorTituloLista]" value="<?php echo $op["CorTituloLista"] ?>">
            <p id="bg-warning" id="mostarCorTituloLista"></p>
        </div>

        <div>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Defina a cor da data">Cor da Data</button><span class="restaurar" id="restartColorDataLista">[restaurar]</span>
            <input id="corInputData" type="color" name="dino_plugin_option_css[CorDataLista]" value="<?php echo $op["CorDataLista"] ?>">
            <p class="bg-warning" id="mostarCorDataLista"></p>
        </div>

     </div> <!-- //listagemDeNoticiaTable -->

     <div role="tabpanel" class="tab-pane" id="noticiaInternaTable">
        <div>
             <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Defina o tamanho do titulo movendo o botão abaixo">Tamanho do Titulo</button><span class="restaurar" id="restartTituloInternodaLista">[restaurar]</span>
             <input type="range" min="0" max="50" step="1" name="dino_plugin_option_css[Titulo]" id="tamanhoFonteTituloInterno" value="<?php echo $op["Titulo"]; ?>">
            <!-- <textarea style="width:100%; height:30px;" name="dino_plugin_option_css[Titulo]" id="dinocss2"><?php echo $op["Titulo"] ?></textarea> -->
            <p class="bg-warning" id="mostrarTamanhoFonteTituloInterno"></p>
            <button class="btMudarTamanhoDoTituloInterno">Aplicar tamanho da imagem</button>
            <input type="hidden" value="<?php echo $cssTitulo ?>" class="padrao"/>
        </div>

        <div>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Defina a cor do título">Cor do título</button><span class="restaurar" id="restartCorTituloLista">[restaurar]</span>
            <input id="corInputTituloInterno" type="color" name="dino_plugin_option_css[CorTituloInterno]" value="<?php echo $op["CorTituloInterno"] ?>">
            <p id="bg-warning" id="mostarCorTituloInterno"></p>
        </div>

        <div>
           <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Defina o tamanho do resumo movendo o botão abaixo">Tamanho da Fonte Resumo</button><span class="restaurar" id="restartInternoResumo">[restaurar]</span>
           <input type="range" min="10" max="50" step="1" name="dino_plugin_option_css[Resumo]" id="tamanhoFonteResumoInterno" value="<?php echo $op["Resumo"]; ?>">
            <!-- <textarea style="width:100%; height:30px;" name="dino_plugin_option_css[Resumo]" id="dinocss3"><?php echo $op["Resumo"] ?></textarea> -->
            <p class="bg-warning" id="mostrarTamanhoFonteResumoInterno"></p>
            <button class="btMudarTamanhoDoResumoInterno">Aplicar tamanho da imagem</button>
            <input type="hidden" value="<?php echo $cssResumo ?>" class="padrao"/>
        </div>

        <div>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Defina a cor do Resumo">Cor do Resumo</button><span class="restaurar" id="restartCordoResumoInterno">[restaurar]</span>
            <input id="corInputResumoInterno" type="color" name="dino_plugin_option_css[CorResumoInterno]" value="<?php echo $op["CorResumoInterno"] ?>">
            <p id="bg-warning" id="mostarCorResumoInterno"></p>
        </div>

        <div>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Defina a cor do Local">Cor do Local e da Data</button><span class="restaurar" id="restartCorLocal">[restaurar]</span>
            <input id="corInputLocalInterno" type="color" name="dino_plugin_option_css[CorLocalInterno]" value="<?php echo $op["CorLocalInterno"] ?>">
            <p id="bg-warning" id="mostarCorLocalInterno"></p>
        </div>

    </div> <!-- //noticiaInternaTable -->

    <div role="tabpanel" class="tab-pane" id="personalizeInternaTable">
        <div>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Personalize suas notícias DINO a vontade. No canto esquerdo temos algumas classes importantes como sugestão. Divirta-se =)">Personalizar</button><span class="restaurar">[restaurar]</span>
            <textarea style="width:100%; height:100px;" name="dino_plugin_option_css[Livre]" id="dinocss1"><?php echo $op["Livre"] ?></textarea>
            <input type="hidden" value="<?php echo $cssLivre ?>" class="padrao"/>
        </div>
    </div>

    </div>

</div>




        <!--<div>
            <h3>CSS Livre <span class="restaurar">[restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:100px;" name="dino_plugin_option_css[Livre]" id="dinocss1"><?php echo $op["Livre"] ?></textarea>
            <input type="hidden" value="<?php echo $cssLivre ?>" class="padrao"/>
        </div>

        <div>
            <h3>Título <span class="restaurar">[restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:30px;" name="dino_plugin_option_css[Titulo]" id="dinocss2"><?php echo $op["Titulo"] ?></textarea>
            <input type="hidden" value="<?php echo $cssTitulo ?>" class="padrao"/>
        </div>

        <div>
            <h3>Resumo <span class="restaurar"> [restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:30px;" name="dino_plugin_option_css[Resumo]" id="dinocss3"><?php echo $op["Resumo"] ?></textarea>
            <input type="hidden" value="<?php echo $cssResumo ?>" class="padrao"/>
        </div>

        <div>
            <h3>Local <span class="restaurar"> [restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:30px;" name="dino_plugin_option_css[Local]" id="dinocss4"><?php echo $op["Local"] ?></textarea>
            <input type="hidden" value="<?php echo $cssLocal ?>" class="padrao"/>
        </div>

        <div>
            <h3>Data <span class="restaurar"> [restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:30px;" name="dino_plugin_option_css[Data]" id="dinocss5"><?php echo $op["Data"] ?></textarea>
            <input type="hidden" value="<?php echo $cssData ?>" class="padrao"/>
        </div>

        <div>
            <h3>Corpo <span class="restaurar"> [restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:30px;" name="dino_plugin_option_css[Corpo]" id="dinocss6"><?php echo $op["Corpo"] ?></textarea>
            <input type="hidden" value="<?php echo $cssCorpo ?>" class="padrao"/>
        </div>

        <div>
            <h3>Link <span class="restaurar"> [restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:30px;" name="dino_plugin_option_css[Link]" id="dinocss7"><?php echo $op["Link"] ?></textarea>
            <input type="hidden" value="<?php echo $cssLink ?>" class="padrao"/>
            <br/>
            <label>Mostrar Link <input type="checkbox" name="dino_plugin_option_css[MostrarLink]" value="<?php echo $op["MostrarLink"]; ?>" <?php checked($op["MostrarLink"] == "on", true); ?> /></label>
        </div>

        <div>
            <h3>Arquivos (imagem, video) <span class="restaurar"> [restaurar]</span></h3>
            <textarea style="width:100%; width: 80%; height:30px;" name="dino_plugin_option_css[Arquivos]" id="dinocss8"><?php echo $op["Arquivos"] ?></textarea>
            <input type="hidden" value="<?php echo $cssArquivos ?>" class="padrao"/>
        </div>-->

        <?php
    }

    public function create_options_field() {
        $op_info = get_option('dino_plugin_option');
        $pagelink = dinopagelink();
        $actual_link = "http://$_SERVER[HTTP_HOST]/noticias-corporativas";
        ?>
        <div>
            <h3>Página da Notícia</h3>
            <a href="<?php echo $actual_link ?>" target="_blank"><?php echo $actual_link ?></a>
        </div>

        <div>
            <h3>Número de registro</h3>
            <input type="text" name="dino_plugin_option[Parceiro]" id="dinooption1" value="<?php echo $op_info["Parceiro"] ?>" />

        </div>

        <div>
            <!--<h3>Html</h3>
            <textarea style="min-width:300px; width: 80%; height:50px;" name="dino_plugin_option[Html]" id="dinooption2"><?php echo $op_info["Html"] ?></textarea>-->
        </div>
        <?php
    }

    public function create_list_field() {
        $op_info = get_option('dino_plugin_list');
        $pagelink = dinopagelistLink();
        $actual_link = "http://$_SERVER[HTTP_HOST]/noticias-corporativas";
        ?>
        <div>
            <h3>Página da Listagem</h3>
            <a href="<?php echo $actual_link ?>"><?php echo $actual_link ?></a>
        </div>

        <div>
            <h3>Altura da Lista</h3>
            <input type="text" name="dino_plugin_list[Height]" id="dinolist1" value="<?php echo $op_info["Height"] ?>" />

        </div>

        <div>
            <h3>Largura da Lista</h3>
            <input type="text" name="dino_plugin_list[Width]" id="dinolist2" value="<?php echo $op_info["Width"] ?>" />

        </div>
        <?php
    }

}

////Widget
//get_option("dino_plugin_widget");
class wp_dino_widget extends WP_Widget {

    // constructor
    function wp_dino_widget() {
        $wOp = get_option("dino_plugin_widget");


        $widget_ops = array('classname' => 'dinoList ', 'description' => __('Lista dos ultimos relases distribuidos no DINO.', 'dinoList'));

        parent::WP_Widget(false, $name = __('DINO Widget', 'wp_dino_widget'), $widget_ops);
    }

    // widget form creation
    function form($instance) {
        $wOp = get_option("dino_plugin_widget");

        // Check values
        if ($instance) {
            $h = esc_attr($instance['height']);
            $w = esc_attr($instance['width']);
        } else {
            $h = $wOp["Height"];
            $w = $wOp["Width"];
        }
        ?>
        <p>
            <!--<label for="<?php echo $this->get_field_name('height'); ?>"><?php _e('Altura:'); ?></label> 
            <input style="width: 50px;" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($h); ?>" />
            <label> px</label>-->
        </p>

        <p>
            <!--<label for="<?php echo $this->get_field_name('width'); ?>"><?php _e('Largura:'); ?></label> 
            <input style="width: 50px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($w); ?>" />
            <label> px</label>-->
        </p>

        <p>
            <label for="<?php echo $this->get_field_name('width'); ?>"><?php _e('Largura:'); ?></label> 
            <input style="width: 100px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($w); ?>" />
            <label> px</label>
        </p>
        <?php
    }

    // widget update
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['width'] = strip_tags($new_instance['width']);
        delete_transient('dino_widget_cache');
        return $instance;
    }

    // widget display
    function widget($args, $instance) {
        extract($args);

        $options = get_transient('dino_widget_cache');
        if ($options === false) {
            $options = get_option("dino_plugin_option");
            set_transient('dino_widget_cache', $options, 3600 * 24);
        }

        $pID = $options["Parceiro"];

        $h = $instance['height'];
        $w = $instance['width'];

        echo '<iframe id="dinoFrame2" border="0" style="min-height:80px" name="widget" height="850px" src="http://app.dino.com.br/widget/index?partnerid='.$pID.'" width="'.$w.'" overflow:="" "hidden"="" marginheight="0" marginwidth="0" frameborder="no" scrolling="no"></iframe>';
        /*
          $data = array("partner" => $pID);
          $curl = curl_init();
          $url = "http://api.dino.com.br/api/news";
          $url = sprintf("%s?%s", $url, http_build_query($data));

          $items = dino_file_get_contents($url);

          if(isset($items) && is_array($items))
          {
          ?>
          <div class="dino-list">
          <?php
          foreach ($items as $item) {
          ?><div class="media" height="70">
          <?php if (isset($item->MainPictureUrl) && !empty($item->MainPictureUrl)) { ?>
          <div class="media-left">
          <a href="<?php echo $item->SourceUrl ?>">
          <img class="media-object" src="<?php echo reset((explode('?', $item->MainPictureUrl))) . "?width=70&height=70&mode=pad" ?>" alt="" />
          </a>

          </div>
          <?php } else { ?>
          <div class="media-left">
          <a href="<?php echo $item->SourceUrl ?>">
          <img class="media-object" src="https://www.dino.com.br/Content/images/comum/bgLogo.png?width=70&height=70&mode=pad" alt="" />
          </a>
          </div>
          <?php } ?>
          <div class="media-body">
          <a href="<?php echo $item->SourceUrl ?>">
          <small><?php echo date('d/m/Y', strtotime($item->PublishedDate)) ?></small>
          <h4 class="media-heading"><?php echo $item->Title ?></h4>
          <p class="media-text"><?php echo $item->Description ?></p>
          </a>
          </div>
          </div><?php
          }
          ?></div><?php
          }
         */
    }

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_dino_widget");'));


function filter_my_search_query( $query ) {
  if ( is_search() && $query->is_main_query() && ! is_admin() ) {
    global $the_original_paged;
    $the_original_paged = $query->get('paged') ? $query->get('paged') : 1;
    $query->set('paged', NULL );
    $query->set('nopaging', TRUE );
  }
}
add_action('pre_get_posts', 'filter_my_search_query', 1);


function add_posts_to_search_query( $posts ) {
  global $wp_query, $the_original_paged;
  if ( ! is_main_query() || is_admin() || ! is_search() )
      return $posts;
  // the wanted posts per page here setted on general settings
  //$new = find_string_at_api('aubicon'); 
  $new = find_string_at_api( get_search_query() );
  $perpage = get_option('posts_per_page'); 
  remove_filter( 'the_posts', 'add_posts_to_search_query' );
  wp_delete_post( $new->id, true );
  if ( ! $new->posts || count( $new->posts ) < 1 ) return $posts;
  $merged = array_merge( $posts, $new->posts );
  $wp_query->found_posts += count( $new->posts );
  // getting the right posts based on current page and posts per page
  $wp_query->posts = array_slice($merged, ( $perpage * ($the_original_paged-1) ), $perpage );
  // set the paged and other wp_query properties to the right value, to make pagination work
  $wp_query->set('paged', $the_original_paged);
  $wp_query->post_count = count($wp_query->posts);
  $wp_query->max_num_pages = ceil( $wp_query->found_posts / $perpage ); 
  unset($the_original_paged); // clean up global variable
  return $wp_query->posts; 
}
add_filter('the_posts', 'add_posts_to_search_query');

function find_string_at_api( $string ) {
    //set_time_limit(0);
    //$request = new SimpleXmlElement( file_get_contents( 'http://api.dino.com.br/v2/rss' ) );

    $options = array(
                      'http'=>array(
                        'method'=>"GET"
                      )
                    );
    $context=stream_context_create($options);
    //var_dump($string);
    //var_dump($find);
    $data = file_get_contents("http://api.dino.com.br/v2/news?Find=".urlencode($string), false,$context);
    $request = json_decode($data); 
    //var_dump($request);
    //$itens =  $request->{'Items'}[0];
    //var_dump($itens->{'Title'});
    //var_dump($request);

    //$results = $request->channel->item ? $request->channel->item : false;

    $results = $request->{'Items'} ? $request->{'Items'} : false;
    $response = (object) array();
    $post_tmp = wp_insert_post( array('post_title' => 'Dino plugin tmp', 'post_status' => 'publish', 'post_type' => 'post') );
    $response->id = $post_tmp;
    $tmp = get_post( $post_tmp );
    foreach( $results as $result ) {
        $result = (array) $result;
        //var_dump($result);
        $tmp_aux = $tmp;
        if ( is_int( stripos( (string) $result['Title'], $string ) ) ) {
            //var_dump( $tmp_aux);exit;
            $tmp_aux->ID = intval( $result['ReleaseId'] );
            $tmp_aux->post_content = $result['Image']->{'Url'};
            $origens  = array('quality=', 'width=');
            $destinos = array('quality=80', 'width=100%');
            $novaImagem    = str_replace($origens, $destinos, $tmp_aux->post_content);
            $tmp_aux->post_title = '<div class="imagem-pesquina-plugindino" style="float: left;width: 100%;max-width: 100%;margin-bottom:20px;"><img style="width:100%;" src="'. $novaImagem .'"></div>' . (string) $result['Title'];
            $tmp_aux->post_content = (string) $result['Body'];
            $tmp_aux->guid = home_url() . '/newsdino/?url='. (string) $result['Title'] .'&releaseId=' . intval( $result['ReleaseId'] );
            $response->posts[] = new WP_Post( $tmp_aux );
        }
    }
    //wp_delete_post( $post_tmp, true );
    return $response;
}

add_filter( 'post_link', 'dino_custom_permalink', 10, 3 );
function dino_custom_permalink( $permalink, $post, $leavename ) {
    if ( is_int( stripos( $post->guid, 'newsdino' ) ) ) {
        $permalink = trailingslashit( home_url( '/newsdino/?url='. (string) $result['title'] .'&releaseId=' . intval( $post->ID ) ) );
    }
    return $permalink;
}

//* add script head *//
function add_canonical_head() {
    $idRelease = $_GET["releaseid"];
    if( empty($idRelease) ) {
        $idRelease =  $_GET["releaseId"];
    }

    if( !empty($idRelease) ) {
        $url = 'http://noticias.dino.com.br/noticia/';
        $urlMontada = $url.'?releaseId='.$idRelease; ?>
        <link rel="canonical" href="<?php echo $urlMontada ?>" />
        <?php
    }
    
    ?>
   
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css" type='text/css' media='all'/>
    <?php
}
add_action('wp_head', 'add_canonical_head');

function wp_dino_font_awesome()
{
    // Register the style like this for a plugin:
    wp_register_style( 'font-awesome', plugins_url( '/assets/css/font-awesome.min.css', __FILE__ ), array(), '20120208', 'all' );
 
    wp_enqueue_style( 'font-awesome' );
}
add_action( 'wp_enqueue_scripts', 'wp_dino_font_awesome' );

function wp_dino_fb(){
?>
    <!--<div id="fb-root"></div>
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v2.9&appId=1057045997773943";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>-->
<?php
}
//add_action('wp_footer', 'wp_dino_fb', -1);

?>