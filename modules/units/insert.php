<?php
/*========================================================================
*   Open eClass 2.3
*   E-learning and Course Management System
* ========================================================================
*  Copyright(c) 2003-2010  Greek Universities Network - GUnet
*  A full copyright notice can be read in "/info/copyright.txt".
*
*  Developers Group:	Costas Tsibanis <k.tsibanis@noc.uoa.gr>
*			Yannis Exidaridis <jexi@noc.uoa.gr>
*			Alexandros Diamantidis <adia@noc.uoa.gr>
*			Tilemachos Raptis <traptis@noc.uoa.gr>
*
*  For a full list of contributors, see "credits.txt".
*
*  Open eClass is an open platform distributed in the hope that it will
*  be useful (without any warranty), under the terms of the GNU (General
*  Public License) as published by the Free Software Foundation.
*  The full license can be read in "/info/license/license_gpl.txt".
*
*  Contact address: 	GUnet Asynchronous eLearning Group,
*  			Network Operations Center, University of Athens,
*  			Panepistimiopolis Ilissia, 15784, Athens, Greece
*  			eMail: info@openeclass.org
* =========================================================================*/

/*
Units module: insert new resource
*/

$require_current_course = true;
include '../../include/baseTheme.php';
include "../../include/lib/fileDisplayLib.inc.php";
$tool_content = $head_content = "";
if ($language == 'greek')
        $lang_editor = 'el';
else
        $lang_editor = 'en';

$head_content .= "<script type='text/javascript'>
_editor_url  = '$urlAppend/include/xinha/';
_editor_lang = '$lang_editor';
</script>
<script type='text/javascript' src='$urlAppend/include/xinha/XinhaCore.js'></script>
<script type='text/javascript' src='$urlAppend/include/xinha/my_config.js'></script>";

$id = intval($_REQUEST['id']);

// Check that the current unit id belongs to the current course
$cours_id = intval($cours_id);
$q = db_query("SELECT * FROM course_units
               WHERE id=$id AND course_id=$cours_id");
if (!$q or mysql_num_rows($q) == 0) {
        $nameTools = $langUnitUnknown;
        draw('', 2, 'units', $head_content);
        exit;
}

if (isset($_POST['submit_doc'])) {
	insert_docs($id);
} elseif (isset($_POST['submit_text'])) {
	$comments = $_POST['comments'];
	insert_text($id);
} elseif (isset($_POST['submit_lp'])) {
	insert_lp($id);
} elseif (isset($_POST['submit_video'])) {
        insert_video($id);
} elseif (isset($_POST['submit_exercise'])) {
        insert_exercise($id);
} elseif (isset($_POST['submit_work'])) {
        insert_work($id);
} elseif (isset($_POST['submit_forum'])) {
        insert_forum($id);
} elseif (isset($_POST['submit_wiki'])) {
        insert_wiki($id);
}


$info = mysql_fetch_array($q);
$navigation[] = array("url"=>"index.php?id=$id", "name"=> htmlspecialchars($info['title']));

switch ($_GET['type']) {
        case 'work': $nameTools = "$langAdd $langInsertWork";
                include 'insert_work.php';
                display_assignments();
                break;
        case 'doc': $nameTools = "$langAdd $langInsertDoc";
                include 'insert_doc.php';
                display_docs();
                break;
        case 'exercise': $nameTools = "$langAdd $langInsertExercise";
                include 'insert_exercise.php';
                display_exercises();
                break;
        case 'text': $nameTools = "$langAdd $langInsertText";
                include 'insert_text.php';
                display_text();
                break;
	case 'lp': $nameTools = "$langAdd $langLearningPath1";
                include 'insert_lp.php';
                display_lp();
                break;
	case 'video': $nameTools = "$langAddV";
                include 'insert_video.php';
                display_video();
                break;
	case 'forum': $nameTools = "$langAdd $langInsertForum";
                include 'insert_forum.php';
                display_forum();
                break;
        case 'wiki': $nameTools = "$langAdd $langInsertWiki";
                include 'insert_wiki.php';
                display_wiki();
                break;
        default: break;
}

draw($tool_content, 2, 'units', $head_content);

// insert docs in database
function insert_docs($id)
{
  $id = intval($id);//SQL INJECTION FIX

	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	
	foreach ($_POST['document'] as $file_id) {
		$order++;
		$file = mysql_fetch_array(db_query("SELECT * FROM document
			WHERE id =" . intval($file_id), $GLOBALS['currentCourseID']), MYSQL_ASSOC);
		$title = (empty($file['title']))? $file['filename']: $file['title'];

    //XSS + SQL INJECTION FIX
    $titleEscaped = xss_sql_filter($title);
    $commentEscaped = xss_sql_filter($file['comment']);

		db_query("INSERT INTO unit_resources SET unit_id=$id, type='doc', title=" .
			 justQuote($titleEscaped) . ", comments=" . justQuote($commentEscaped) .
			 ", visibility='$file[visibility]', `order`=$order, `date`=NOW(), res_id=".intval($file[id]),
			 $GLOBALS['mysqlMainDb']); 
	}
	header('Location: index.php?id=' . $id);
	exit;
}

// insert text in database
function insert_text($id)
{
  $id = intval($id);//SQL INJECTION FIX

	global $title, $comments;
	
	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	$order++;

  //XSS + SQL INJECTION FIX
  $commentEscaped = xss_sql_filter($comments);

	db_query("INSERT INTO unit_resources SET unit_id=$id, type='text', title='', 
		comments=" . justQuote($commentEscaped) . ", visibility='v', `order`=$order, `date`=NOW(), res_id=0",
		$GLOBALS['mysqlMainDb']);
			
	header('Location: index.php?id=' . $id);
	exit;
}


// insert lp in database
function insert_lp($id)
{
  $id = intval($id);//SQL INJECTION FIX

	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	
	foreach ($_POST['lp'] as $lp_id) {
		$order++;
		$lp = mysql_fetch_array(db_query("SELECT * FROM lp_learnPath
			WHERE learnPath_id =" . intval($lp_id), $GLOBALS['currentCourseID']), MYSQL_ASSOC);
		if ($lp['visibility'] == 'HIDE') {
			 $visibility = 'i';
		} else {
			$visibility = 'v';
		}

      //XSS + SQL INJECTION FIX
      $nameEscaped = xss_sql_filter($lp['name']);
      $commentEscaped = xss_sql_filter($lp['comment']);
      $id = intval($id);
			db_query("INSERT INTO unit_resources SET unit_id=$id, type='lp', title=" .
			justQuote($nameEscaped) . ", comments=" . justQuote($commentEscaped) .
			", visibility='$visibility', `order`=$order, `date`=NOW(), res_id=".intval($lp[learnPath_id]),
			$GLOBALS['mysqlMainDb']);
	}
	header('Location: index.php?id=' . $id);
	exit;
}

// insert video in database
function insert_video($id)
{
  $id = intval($id);//SQL INJECTION FIX

	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	
	foreach ($_POST['video'] as $video_id) {
		$order++;
                list($table, $res_id) = explode(':', $video_id);
                $res_id = intval($res_id);
                $table = ($table == 'video')? 'video': 'videolinks';
		$row = mysql_fetch_array(db_query("SELECT * FROM $table
			WHERE id = $res_id", $GLOBALS['currentCourseID']), MYSQL_ASSOC);
      
      //XSS + SQL INJECTION FIX
      $titleEscaped = xss_sql_filter($row['titre']);
      $commentEscaped = xss_sql_filter($row['description']);
      $order = intval($order);
      $res_id = intval($res_id);
      db_query("INSERT INTO unit_resources SET unit_id=$id, type='$table', title=" . justQuote($titleEscaped) . ", comments=" . justQuote($commentEscaped) . ", visibility='v', `order`=$order, `date`=NOW(), res_id=$res_id", $GLOBALS['mysqlMainDb']);
	}
	header('Location: index.php?id=' . $id);
	exit;
}

// insert work (assignment) in database
function insert_work($id)
{
  $id = intval($id);//SQL INJECTION FIX

	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	
	foreach ($_POST['work'] as $work_id) {
		$order++;
		$work = mysql_fetch_array(db_query("SELECT * FROM assignments
			WHERE id =" . intval($work_id), $GLOBALS['currentCourseID']), MYSQL_ASSOC);
		if ($work['active'] == '0') {
			 $visibility = 'i';
		} else {
			$visibility = 'v';
		}

    //XSS + SQL INJECTION FIX
    $titleEscaped = xss_sql_filter($work['title']);
    $commentEscaped = xss_sql_filter($work['description']);
    $order = intval($order);
    $work[id] = intval($work[id]);
		db_query("INSERT INTO unit_resources SET
                                unit_id = $id,
                                type = 'work',
                                title = " . justQuote($titleEscaped) . ",
                                comments = " . justQuote($commentEscaped) . ",
                                visibility = '$visibility',
                                `order` = $order,
                                `date` = NOW(),
                                res_id = $work[id]",
			 $GLOBALS['mysqlMainDb']); 
	}
	header('Location: index.php?id=' . $id);
	exit;
}


// insert exercise in database
function insert_exercise($id)
{
  $id = intval($id);//SQL INJECTION FIX

	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	
	foreach ($_POST['exercise'] as $exercise_id) {
		$order++;
		$exercise = mysql_fetch_array(db_query("SELECT * FROM exercices
			WHERE id =" . intval($exercise_id), $GLOBALS['currentCourseID']), MYSQL_ASSOC);
		if ($exercise['active'] == '0') {
			 $visibility = 'i';
		} else {
			$visibility = 'v';
		}

    //XSS + SQL INJECTION FIX
    $titleEscaped = xss_sql_filter($exercise['titre']);
    $commentEscaped = xss_sql_filter($exercise['description']);
    $order = intval($order);
    $exercise[id] = intval($exercise[id]);
		db_query("INSERT INTO unit_resources SET unit_id=$id, type='exercise', title=" .
			justQuote($titleEscaped) . ", comments=" . justQuote($commentEscaped) .
			", visibility='$visibility', `order`=$order, `date`=NOW(), res_id=$exercise[id]",
			$GLOBALS['mysqlMainDb']); 
	}
	header('Location: index.php?id=' . $id);
	exit;
}

// insert forum in database
function insert_forum($id)
{
  $id = intval($id);//SQL INJECTION FIX

	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	foreach ($_POST['forum'] as $for_id) {
		$order++;
		$ids = explode(':', $for_id);
		if (count($ids) == 2) {
                        list($forum_id, $topic_id) = $ids;
			$topic = mysql_fetch_array(db_query("SELECT * FROM topics
				WHERE topic_id =" . intval($topic_id) ." AND forum_id =" . intval($forum_id), $GLOBALS['currentCourseID']), MYSQL_ASSOC);

      //XSS + SQL INJECTION FIX
      $titleEscaped = xss_sql_filter($topic['topic_title']);
      $topic[topic_id] = intval($topic[topic_id]);
      $order = intval($order);
			db_query("INSERT INTO unit_resources SET unit_id=$id, type='topic', title=" .
				justQuote($titleEscaped) .", visibility='v', `order`=$order, `date`=NOW(), res_id=$topic[topic_id]",
			$GLOBALS['mysqlMainDb']);		
		} else {
      //XSS + SQL INJECTION FIX
      $titleEscaped = xss_sql_filter($forum['forum_name']);
      $commentEscaped = xss_sql_filter($forum['forum_desc']);

      $forum_id = $ids[0];
			$forum = mysql_fetch_array(db_query("SELECT * FROM forums
				WHERE forum_id =" . intval($forum_id), $GLOBALS['currentCourseID']), MYSQL_ASSOC);
			db_query("INSERT INTO unit_resources SET unit_id=$id, type='forum', title=" .
				justQuote($titleEscaped) . ", comments=" . justQuote($commentEscaped) .
				", visibility='v', `order`=$order, `date`=NOW(), res_id=$forum[forum_id]",
				$GLOBALS['mysqlMainDb']);
		} 
	}
	header('Location: index.php?id=' . $id);
	exit;
}


// insert wiki in database
function insert_wiki($id)
{
  $id = intval($id);//SQL INJECTION FIX

	list($order) = mysql_fetch_array(db_query("SELECT MAX(`order`) FROM unit_resources WHERE unit_id=$id"));
	
	foreach ($_POST['wiki'] as $wiki_id) {
		$order++;
		$wiki = mysql_fetch_array(db_query("SELECT * FROM wiki_properties
			WHERE id =" . intval($wiki_id), $GLOBALS['currentCourseID']), MYSQL_ASSOC);

    //XSS + SQL INJECTION FIX
    $titleEscaped = xss_sql_filter($wiki['title']);
    $descEscaped = xss_sql_filter($wiki['description']);

		db_query("INSERT INTO unit_resources SET unit_id=$id, type='wiki', title=" .
			justQuote($titleEscaped) . ", comments=" . justQuote($descEscaped) .
			", visibility='v', `order`=$order, `date`=NOW(), res_id=$wiki[id]",
			$GLOBALS['mysqlMainDb']); 
	}
	header('Location: index.php?id=' . $id);
	exit;
}
